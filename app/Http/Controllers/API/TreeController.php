<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Tree as TreeResource;
use App\Models\Tree;
use Validator;
use DB;
use Image;
use QrCode;

class TreeController extends BaseController
{
    public function index()
    {
        $trees = Tree::all();
        return $this->handleResponse(TreeResource::collection($trees), 'Tree have been retrieved!');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'image' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        $tree = Tree::create($input);

        $image = $request->file('image');
        $filePath = public_path('/tree');
        $imageName = time().'.'.$request->image->extension();
     
        $img = Image::make($image->path());
        $img->resize(1024, 1024, function ($const) {
            $const->aspectRatio();
        })->save($filePath.'/'.$imageName);
   
        $filePath = public_path('/images');
        $image->move($filePath, $imageName);

        // update INV_ATTACHMEN
        $updateTree = Tree::find($tree->INV_NOMBORIDS);
        $updateTree->INV_ATTACHMEN = $imageName;
        $updateTree->save();

        // create qr code
        $this->qrcode($tree->INV_NOMBORIDS);

        return $this->handleResponse($updateTree, 'Tree created!');
    }

    public function qrcode($id)
    {
        $tree = Tree::find($id);
        $qrcode = null;

        // generate QR code
        $qrcode = "1. No Inventori: ".$tree->INV_NOMBORIDS;
        $qrcode .= "\n2. Nama: ".$tree->INV_INVENTORI;
        $qrcode .= "\n3. Lokasi: ".$tree->INV_LOKASLAND;
        $qrcode .= "\n4. Usia: ".$tree->INV_AGEGTREES;
        $qrcode .= "\n5. Koordinat X: ".$tree->INV_KOORDINAX;
        $qrcode .= "\n6. Koordinat Y: ".$tree->INV_KOORDINAY;
        $qrcode .= "\n7. Tarikh Daftar: ".$tree->INV_ENTRYDATE;
        $qrcode .= "\n\n. Sekiranya terdapat aduan mengenai pokok, tuan/puan boleh membuat aduan pada Sistem SisPAA Negeri Melaka di pautan : https://melaka.spab.gov.my/eApps/system/index.do. Sekian,terima kasih.";

        QrCode::size(500)
            ->format('jpg')
            ->generate($qrcode, public_path('images/'.$id.'.jpg'));
    }

   
    public function show(Request $request, $id)
    {
        $input = $request->all();

        if($input){
            // get by radius from current location
            $latitude = $input['latitude'];
            $longitude = $input['longitude'];
            $radius = $input['radius'];

            $tree = DB::select(DB::raw("SELECT INV_NOMBORIDS,INV_INVENTORI,INV_POKOKCODE,INV_KOORDINAY,INV_KOORDINAX, distance FROM (SELECT *, (((acos(sin(( :lat1 * pi() / 180)) * sin((`INV_KOORDINAX` * pi() / 180)) + cos(( :lat2 * pi() /180 ))* cos((`INV_KOORDINAX` * pi() / 180)) * cos((( :lon - `INV_KOORDINAY`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) AS distance FROM `LAN_INVENTORI`) myTable WHERE distance <= :radi"),
                array(
                    'lat1' => $latitude,
                    'lat2' => $latitude,
                    'lon' => $longitude,
                    'radi' => $radius
                ));
            $jumlah = count($tree);
            return $this->handleResponse($tree, $jumlah.' tree in radius of '.$radius.'KM retrieved.');
                
        } else {
            $tree = Tree::find($id);
            $tree['id'] = $tree->INV_NOMBORIDS;
            $tree['image_url'] = env('APP_URL').'/images/'.$tree->INV_ATTACHMEN;
            return $this->handleResponse($tree, 'Tree retrieved.');
        }
        
        if (is_null($tree)) {
            return $this->handleError('Tree not found!');
        }
    }
    

    public function update(Request $request, Tree $tree)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        $tree->name = $input['name'];
        $tree->details = $input['details'];
        $tree->save();
        
        return $this->handleResponse(new TreeResource($tree), 'Tree successfully updated!');
    }
   
    public function destroy(Tree $tree)
    {
        $tree->delete();
        return $this->handleResponse([], 'Tree deleted!');
    }
}