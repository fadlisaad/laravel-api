<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Tree as TreeResource;
use App\Models\Tree;
use Validator;


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

   
    public function show($id)
    {
        $tree = Tree::find($id);
        if (is_null($tree)) {
            return $this->handleError('Tree not found!');
        }
        return $this->handleResponse(new TreeResource($tree), 'Tree retrieved.');
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