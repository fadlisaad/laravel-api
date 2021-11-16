<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Tree as TreeResource;
use App\Models\Tree;
use Validator;
use DB;


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
            'name' => 'required',
            'details' => 'required'
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        $tree = Tree::create($input);
        return $this->handleResponse(new TreeResource($tree), 'Tree created!');
    }

   
    public function show(Request $request, $id)
    {
        $input = $request->all();

        if($input){
            // get by radius from current location
            $latitude = $input['latitude'];
            $longitude = $input['longitude'];
            $radius = $input['radius'];

            $tree = DB::select(DB::raw("SELECT * FROM (SELECT *, (((acos(sin(( :lat1 * pi() / 180)) * sin((`INV_KOORDINAY` * pi() / 180)) + cos(( :lat2 * pi() /180 ))* cos((`INV_KOORDINAY` * pi() / 180)) * cos((( :lon - `INV_KOORDINAX`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) AS distance FROM `LAN_INVENTORI`) myTable WHERE distance <= :radi"),
                array(
                    'lat1' => $latitude,
                    'lat2' => $latitude,
                    'lon' => $longitude,
                    'radi' => $radius
                ));
            $jumlah = count($tree);
            return $this->handleResponse($tree, $jumlah.' tree in radius of '.$radius.'KM retrieved.');
                
        } else {
            $tree = Tree::where('INV_NOMBORIDS', $id)->first();
            return $this->handleResponse(new TreeResource($tree), 'Tree retrieved.');
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