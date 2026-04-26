<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Traits\ApiResponse;
class CategoryController { use ApiResponse; public function index(){ return $this->success('Categories fetched.', Category::query()->with('children')->whereNull('parent_id')->get()); } }
