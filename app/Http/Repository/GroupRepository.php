<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    public function group()
    {
        return DB::table('groups')->get();
    }

    public function detail_group($id)
    {
        return DB::table('groups')->where('id', $id)->first();
    }

    public function store($request)
    {
        return DB::table('groups')
            ->insert([
                'name' => $request->name,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function update($request, $id)
    {
        return DB::table('groups')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
