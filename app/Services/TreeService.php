<?php

namespace App\Services;

use App\Models\Tree;
use App\Repositories\TreeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TreeService
{
    private const BASE_LEVEL =1;
    private const POSITIONS =2;
    private TreeRepository $treeRepository;

    /**
     * @param TreeRepository $treeRepository
     */
    public function __construct(TreeRepository $treeRepository)
    {
        $this->treeRepository = $treeRepository;
    }

    public function create(Request $request)
    {
        return $this->treeRepository->create( $request);
    }
    public function autoCreate(int $qty=0, Tree $parent=null )
    {
        $nodes=[];
        if(!isset($parent)){
            $parent = $this->treeRepository->createNode(null,null, self::BASE_LEVEL);
        }
        $this->buildTree($parent,null,self::BASE_LEVEL, $qty);

        return $nodes ;
    }

    private function buildTree(Tree|null $parent=null,  int|null $position=null, int|null $level=0,int $qty=0) : array
    {
        $nodes=[];
        $children=[];
        if ($qty>0) {
            for ($i = 1; $i <= self::POSITIONS; $i++) {

                $node = $this->treeRepository->createNode($parent, $i, $level);

                $nodes[] = $node;

                $qty--;

            }

            foreach ($nodes as $node){

                $this->buildTree($node,null,null, $qty);
            }
            $qty--;
        }


        return $nodes;
    }

    public function isExistsTree() : bool
    {
        return $this->treeRepository->isExistsTree();
    }
    public function getTree() : array
    {
        $root = Tree::whereNull('parent_id')->first();
        $tree = $this->getChildren($root);



        return $tree;
    }
    public function getMaxLevel() :int
    {
        dd($this->treeRepository->getMaxLevel());
    }
    protected function getChildren($parent,array $tree =[])
    {
        $node=[];
        $childs=[];
        if(isset($parent->parent_id)){
            $path=$parent->parent_id.'.'.$parent->id;
        } else {
            $path='.'.$parent->id.'.';
        }
         $parent->setChildren(Tree::where('path', 'like', $path.'%')->get());

        $tree['id']= $parent->id;
        $tree['path']= $parent->path;


        foreach ($parent->getChildren() as $child){

            $tree['children'][]=$this->getChildren($child,$tree);

        }


        return $tree;
    }
    private  function drawTree(string $html='', Tree $tree) :string
    {

        return $html;
    }

    public function drawChildren(string $html ='', array $tree ) :string
    {

        $html .= '<ul>';
        $html .= "<li><a href='#'" . $tree['id']."</a></li>";
        if (isset($tree['children'])) {

        foreach ($tree['children'] as $child) {
            $html .= $this->drawChildren($html, $child);
        }
        }

        $html.='</ul>';
        $html.="</div>";
        return $html;
    }



}
