<?php

namespace App\Http\Repository;

use App\Models\MenuSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionRepository
{
    protected $section;

    public function __construct(MenuSection $sctn)
    {
        $this->section = $sctn;
    }

    public function get_all_section()
    {
        return $this->section->orderBy('order', 'ASC')->get();
    }

    public function get_all_section_active()
    {
        return $this->section->where('status', 'active')->orderBy('order', 'ASC')->get();
    }

    public function get_section($id)
    {
        return DB::table('menu_sections')->where('id', $id)->first();
    }

    public function update($request, $id)
    {
        if ($request->status !== null && $request->icons !== null) {
            // Jika keduanya ada

            DB::table('menus')
                ->where('section_id', $id)
                ->update([
                    'status' => 'active'
                ]);

            return DB::table('menu_sections')->where('id', $id)->update([
                'name_section' => $request->name_section,
                'status' => $request->status,
                'icons' => $request->icons,
            ]);
        } elseif ($request->status !== null) {
            // Jika hanya input status yang ada

            DB::table('menus')
                ->where('section_id', $id)
                ->update([
                    'status' => 'active'
                ]);

            return DB::table('menu_sections')->where('id', $id)->update([
                'name_section' => $request->name_section,
                'status' => $request->status,
            ]);
        } elseif ($request->icons !== null) {
            // Jika hanya input icon yang ada

            DB::table('menus')
                ->where('section_id', $id)
                ->update([
                    'status' => 'inactive'
                ]);

            return DB::table('menu_sections')->where('id', $id)->update([
                'name_section' => $request->name_section,
                'icons' => $request->icons,
                'status' => 'inactive'
            ]);
        } else {
            // Jika keduanya tidak ada

            DB::table('menus')
                ->where('section_id', $id)
                ->update([
                    'status' => 'inactive'
                ]);

            return DB::table('menu_sections')->where('id', $id)->update([
                'name_section' => $request->name_section,
                'status' => 'inactive'
            ]);
        }
    }

    public function store($request)
    {
        $section = DB::table('menu_sections')->orderBy('order', 'DESC')->first();

        return DB::table('menu_sections')->insert([
            'name_section' => $request->name_section,
            'icons' => $request->icons,
            'order' => $section->order + 1,
            'status' => 'active'
        ]);
    }
}
