<?php

use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionGroup;
use App\Models\UserGroup;

class NavHelper
{
    public static function list_menu($group)
    {
        $data = DB::table('menus')
            ->select('menus.name_menu', 'menus.url', 'menus.section_id', 'menus.icons', 'menus.order')
            ->join('actions', 'actions.menu_id', '=', 'menus.id')
            ->join('master_actions', 'master_actions.id', '=', 'actions.master_action_id')
            ->join('action_groups', 'action_groups.action_id', '=', 'actions.id')
            ->where('master_actions.name', 'view')
            ->where('action_groups.group_id', $group)
            ->orderBy('menus.order', 'ASC')
            ->get();

        // dd($data);
        // dd(Auth::user()->user_group);

        $result = [];

        foreach ($data as $value) {
            $hasSection = DB::table('menu_sections')->where('id', $value->section_id)->first();

            if ($hasSection) {
                $sectionData = [
                    'section_id' => $value->section_id,
                    'section' => $hasSection->name_section,
                    'icons' => $hasSection->icons,
                    'active' => [],
                    'order' => $hasSection->order,
                    'menu' => [
                        [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ]
                    ]
                ];

                // Check if the section_id already exists in $result
                $sectionIdExists = false;
                foreach ($result as &$existingSection) {
                    if ($existingSection['section_id'] === $value->section_id) {
                        $existingSection['menu'][] = [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ];

                        $urlSegments = explode('/', $value->url);
                        foreach ($urlSegments as $segment) {
                            if ($segment !== '') { // Exclude empty segments
                                $existingSection['active'][] = $segment;
                            }
                        }

                        $sectionIdExists = true;
                        break;
                    }
                }

                if (!$sectionIdExists) {
                    $result[] = $sectionData;
                }

                foreach ($result as &$section) {
                    $aktif = [];
                    foreach ($section['menu'] as $menu) {
                        $aktif[] = $menu['url'];
                    }
                    $section['aktif'] = $aktif;
                }
            } else {
                // Menu tanpa section
                $result[] = [
                    'section_id' => $value->section_id,
                    'section' => $value->name_menu,
                    'icons' => $value->icons,
                    'order' => $value->order,
                    'url' => $value->url
                ];
            }
        }

        // Menggunakan usort() untuk mengurutkan $result berdasarkan "order"
        usort($result, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        // dd($result);
        return $result;
    }

    public static function cekAkses($user_id, $menu_name, $action_name)
    {
        $cekAkses = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('groups', 'user_groups.group_id', '=', 'groups.id')
            ->join('action_groups', 'groups.id', '=', 'action_groups.group_id')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->join('menus', 'actions.menu_id', '=', 'menus.id') // Ganti 'menu_sections' menjadi 'menus'
            ->join('menu_sections', 'menus.section_id', '=', 'menu_sections.id')
            ->join('master_actions', 'actions.master_action_id', '=', 'master_actions.id')
            ->select('menus.id') // Ganti 'menu_sections.id' menjadi 'menus.id'
            ->where([
                'users.id' => $user_id,
                'menus.name_menu' => $menu_name, // Ganti 'menu_sections.name_section' menjadi 'menus.name_menu'
                'master_actions.name' => $action_name,
            ])
            ->first();

        return $cekAkses !== null;
    }

    public static function switched($group_id, $menu_id)
    {
        $master_action = DB::table('master_actions')->get();

        $result = DB::table('action_groups')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->where('action_groups.group_id', $group_id)
            ->where('actions.menu_id', $menu_id)
            ->get();

        if (count($master_action) === count($result)) {
            return $result !== null;
        }
    }

    public static function create_checked($group_id, $menu_id, $aksi)
    {
        $result = DB::table('action_groups')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->select('actions.id')
            ->where([
                'action_groups.group_id' => $group_id,
                'actions.menu_id' => $menu_id,
                'actions.master_action_id' => $aksi,
            ])
            ->first();

        return $result !== null;
    }

    public static function action($position, $id = 0)
    {
        $menu = DB::table('menus')
            ->where('url', Session::get('menu_active'))
            ->first();

        if (empty($menu)) {
            return [];
        } else {
            $cekAkses = DB::table('action_groups')
                ->join('actions', 'action_groups.action_id', '=', 'actions.id')
                ->join('master_actions', 'actions.master_action_id', '=', 'master_actions.id')
                ->select('master_actions.name') // Ganti 'master_actions.id' dengan 'master_actions.name'
                ->where([
                    'action_groups.group_id' => Auth::user()->user_group[0]->group_id,
                    'actions.menu_id' => $menu->id,
                ])
                ->get();
            $arr = "";
            foreach ($cekAkses as $key => $value) {
                $button = DB::table('button')->where('position', $position)->where('name', $value->name)->first();
                if ($button) {
                    $x = str_replace('[id]', $id, $button->code);
                    $arr .= Blade::render($x);
                }
            }
            return $arr;
        }
    }

    public static function name_menu($session)
    {
        $name_menu = DB::table('menus')
            ->select('name_menu')
            ->where('url', $session)
            ->first();

        return $name_menu;
    }

    public static function rupiah($angka)
    {
        $rupiah = "Rp. " . number_format($angka, 0, ',', '.');
        return $rupiah;
    }

    // Query untuk mengecek apakah barang_id ada di tabel mutasi
    public static function hasMutasi($itemId)
    {
        return DB::table('mutasis')
            ->where('barang_id', $itemId)
            ->exists();
    }

    // Query untuk mengecek apakah mutasi sudah diverifikasi
    public static function isMutasiVerified($itemId)
    {
        return DB::table('mutasis')
            ->where('barang_id', $itemId)
            ->where('verified', 1)
            ->exists();
    }

    // Query untuk mengecek apakah barang_id ada di tabel mutasi
    public static function hasKeluar($itemId)
    {
        return DB::table('barang_keluars')
            ->where('barang_id', $itemId)
            ->exists();
    }

    // Query untuk mengecek apakah mutasi sudah diverifikasi
    public static function isKeluarVerified($itemId)
    {
        return DB::table('barang_keluars')
            ->where('barang_id', $itemId)
            ->where('verified', 1)
            ->exists();
    }

    public static function renderKeluarButton($itemId)
    {
        if (!self::hasKeluar($itemId)) {
            return '<button onclick="return keluar(' . $itemId . ')"
                    class="btn btn-danger btn-sm btn-icon"`
                    title="Keluar Barang">
                    <i class="bi bi-dropbox"></i>
                </button>';
        } else {
            if (self::isKeluarVerified($itemId)) {
                return '<button onclick="return keluar(' . $itemId . ')"
                        class="btn btn-danger btn-sm btn-icon"
                        title="Keluar Barang">
                        <i class="bi bi-dropbox"></i>
                    </button>';
            } else {
                return '<button onclick="waiting()"
                        class="btn btn-danger btn-sm btn-icon"
                        title="Keluar Barang">
                        <i class="bi bi-dropbox"></i>
                    </button>';
            }
        }
    }

    // Function untuk menampilkan tombol mutasi berdasarkan kondisi yang diberikan
    public static function renderMutasiButton($itemId)
    {
        if (!self::hasMutasi($itemId)) {
            return '<button onclick="return mutasi(' . $itemId . ')"
                    class="btn btn-yellow btn-sm btn-icon"`
                    title="Mutasi Barang">
                    <i class="bi bi-arrow-left-right"></i>
                </button>';
        } else {
            if (self::isMutasiVerified($itemId)) {
                return '<button onclick="return mutasi(' . $itemId . ')"
                        class="btn btn-yellow btn-sm btn-icon"
                        title="Mutasi Barang">
                        <i class="bi bi-arrow-left-right"></i>
                    </button>';
            } else {
                return '<button onclick="waiting()"
                        class="btn btn-yellow btn-sm btn-icon"
                        title="Mutasi Barang">
                        <i class="bi bi-arrow-left-right"></i>
                    </button>';
            }
        }
    }
}
