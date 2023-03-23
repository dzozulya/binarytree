<?php

namespace App\Repositories;

use App\Models\Tree;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class TreeRepository implements RepositoryInterface
{


    private Tree $tree;
    private int $qty;
    private  $parentTree;


    /**
     * @param DatabaseManager $db
     */
    public function __construct(Tree $tree)
    {
        $this->tree = $tree;


    }


    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    public function create(Request $request)
    {
        $currentTree = $this->tree;
        $currentTree->parent_id = $request->parent_id;
        $currentTree->position = $request->position;
        $currentTree->title = $request->title;
        $currentTree->save();
        $this->parentTree = isset($this->tree->parent_id)? Tree::where('id', $this->tree->parent_id)->first() : null;
       $currentTree->path = $this->createPath($currentTree);
        $currentTree->level = !empty($this->parentTree)?$this->parentTree->level+1 : self::BASE_LEVEL;
        $currentTree->save();


        return $currentTree;

    }

    public function removeById(int $id)
    {
        // TODO: Implement removeById() method.
    }

    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }
    private function createPath(Tree $current) : string
    {
        $path='';
        $parent = isset($current->parent_id)?Tree::where('id', $current->parent_id)->first() :null;
        if(!empty($parent)){

            $path = $parent->parent_id . '.'.$current->parent_id . '.' .$current->id;

        } else {
            $path = ".".$current->id;
        }
        return $path;
    }

    public function createNode(Tree $parent=null, int|null $position =null, int|null $level) : Tree
    {
        $tree= new Tree();
        $tree->parent_id = $parent?->id;
        $tree->position= $parent? $position :null;
        $tree->save();
        $tree->path=$this->createPath($tree);
        $tree->level =isset($parent)?$parent->level+1 : $level;
        $tree->save();
        return $tree;
    }

    public function isExistsTree() :bool
    {
        return !empty(Tree::all()->first());

    }

    public function getMaxLevel() : int
    {
        return Tree::all()->max('level');
    }


}
