<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSection;
use Illuminate\Http\Request;
use App\Http\Repository\MenuRepository;
use App\Http\Repository\PermissionRepository;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class MenuController extends Controller
{
    protected $menu, $permission;

    public function __construct(MenuRepository $menu, PermissionRepository $permission)
    {
        $this->menu = $menu;
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/menu');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Menu", "view") !== true) {
            return view('error.403');
        }

        $menus = $this->menu->get_menu_section();
        $sections = $this->menu->get_section();

        return view('menu.list', compact('menus', 'sections'));
    }

    public function create_section(Request $request)
    {
        $request->validate([
            'name_section' => 'required|string',
            'icons' => 'required|string',
        ]);

        MenuSection::create([
            'name_section' => $request->input('name_section'),
            'icons' => $request->input('icons'),
            'status' => 'active',
        ]);

        Alert::success('Success', 'Berhasil ditambahkan.');
        return redirect()->back();
    }

    public function create_menu(Request $request)
    {
        $request->validate([
            'name_menu' => 'required|string',
            'url' => 'required|string',
            'section_id' => 'required|exists:menu_sections,id',
        ]);

        $menu = Menu::create([
            'parent_id' => 0,
            'section_id' => $request->input('section_id'),
            'name_menu' => $request->input('name_menu'),
            'url' => $request->input('url'),
            'icons' => '',
            'order' => $request->input('order'),
            'status' => 'active',
        ]);

        Alert::success('Success', 'Berhasil ditambahkan.');
        return redirect()->back();
    }

    public function detail_section($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Section',
            'data' => $this->menu->detail_section($id),
        ]);
    }

    public function detail_menu($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Menu',
            'data' => $this->menu->detail_menu($id),
        ]);
    }

    public function update_section(Request $request, $id)
    {
        $request->validate([
            'name_section' => 'required',
            'icons' => 'required',
        ]);

        $section = MenuSection::find($id);

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui.',
        ]);
    }

    public function update_menu(Request $request, $id)
    {
        $request->validate([
            'section_id' => 'required',
            'name_menu' => 'required',
            'url' => 'required',
            'order' => 'required',
        ]);

        $menu = Menu::find($id);

        $menu->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui.',
        ]);
    }

    public function destroy_menu($id)
    {
        $data = Menu::findOrFail($id);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus',
        ]);
    }

    public function destroy_section($id)
    {
        $section = MenuSection::findOrFail($id);

        if (Menu::where('section_id', $section->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus, Section memiliki menu'
            ]);
        } else {
            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus'
            ]);
        }
    }
}
