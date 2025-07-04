<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Dashboard
        Permission::firstOrCreate(['name' => 'view_dashboard']);

        // User Management
        Permission::firstOrCreate(['name' => 'view_users']);
        Permission::firstOrCreate(['name' => 'create_users']);
        Permission::firstOrCreate(['name' => 'edit_users']);
        Permission::firstOrCreate(['name' => 'delete_users']);

        // Role Management
        Permission::firstOrCreate(['name' => 'view_roles']);
        Permission::firstOrCreate(['name' => 'create_roles']);
        Permission::firstOrCreate(['name' => 'edit_roles']);
        Permission::firstOrCreate(['name' => 'delete_roles']);

        // Permission Management
        Permission::firstOrCreate(['name' => 'view_permissions']);
        Permission::firstOrCreate(['name' => 'create_permissions']);
        Permission::firstOrCreate(['name' => 'edit_permissions']);
        Permission::firstOrCreate(['name' => 'delete_permissions']);
        
        // Permission Slider
        Permission::firstOrCreate(['name' => 'view_sliders']);
        Permission::firstOrCreate(['name' => 'create_sliders']);
        Permission::firstOrCreate(['name' => 'edit_sliders']);
        Permission::firstOrCreate(['name' => 'delete_sliders']);

        // Permission Infaq
        Permission::firstOrCreate(['name' => 'view_infaqs']);
        Permission::firstOrCreate(['name' => 'create_infaqs']);
        Permission::firstOrCreate(['name' => 'edit_infaqs']);
        Permission::firstOrCreate(['name' => 'delete_infaqs']);

        // Sekolah Management
        Permission::firstOrCreate(['name' => 'view_sekolahs']);
        Permission::firstOrCreate(['name' => 'create_sekolahs']);
        Permission::firstOrCreate(['name' => 'edit_sekolahs']);
        Permission::firstOrCreate(['name' => 'delete_sekolahs']);

        // Settings Management
        Permission::firstOrCreate(['name' => 'view_settings']);
        Permission::firstOrCreate(['name' => 'create_settings']);
        Permission::firstOrCreate(['name' => 'edit_settings']);
        Permission::firstOrCreate(['name' => 'delete_settings']);


        // Jurusan Management
        Permission::firstOrCreate(['name' => 'view_jurusans']);
        Permission::firstOrCreate(['name' => 'create_jurusans']);
        Permission::firstOrCreate(['name' => 'edit_jurusans']);
        Permission::firstOrCreate(['name' => 'delete_jurusans']);

        // Kelas Management
        Permission::firstOrCreate(['name' => 'view_kelas']);
        Permission::firstOrCreate(['name' => 'create_kelas']);
        Permission::firstOrCreate(['name' => 'edit_kelas']);
        Permission::firstOrCreate(['name' => 'delete_kelas']);

        // PTK Management
        Permission::firstOrCreate(['name' => 'view_ptks']);
        Permission::firstOrCreate(['name' => 'create_ptks']);
        Permission::firstOrCreate(['name' => 'edit_ptks']);
        Permission::firstOrCreate(['name' => 'delete_ptks']);

        // Siswa Management
        Permission::firstOrCreate(['name' => 'view_siswas']);
        Permission::firstOrCreate(['name' => 'create_siswas']);
        Permission::firstOrCreate(['name' => 'edit_siswas']);
        Permission::firstOrCreate(['name' => 'delete_siswas']);

        // Berita Management
        Permission::firstOrCreate(['name' => 'view_beritas']);
        Permission::firstOrCreate(['name' => 'create_beritas']);
        Permission::firstOrCreate(['name' => 'edit_beritas']);
        Permission::firstOrCreate(['name' => 'delete_beritas']);

        // Fasilitas Management
        Permission::firstOrCreate(['name' => 'view_fasilitas']);
        Permission::firstOrCreate(['name' => 'create_fasilitas']);
        Permission::firstOrCreate(['name' => 'edit_fasilitas']);
        Permission::firstOrCreate(['name' => 'delete_fasilitas']);

        // Ekstrakurikuler Management
        Permission::firstOrCreate(['name' => 'view_ekstrakurikulers']);
        Permission::firstOrCreate(['name' => 'create_ekstrakurikulers']);
        Permission::firstOrCreate(['name' => 'edit_ekstrakurikulers']);
        Permission::firstOrCreate(['name' => 'delete_ekstrakurikulers']);

        // Hubin Management
        Permission::firstOrCreate(['name' => 'view_hubins']);
        Permission::firstOrCreate(['name' => 'create_hubins']);
        Permission::firstOrCreate(['name' => 'edit_hubins']);
        Permission::firstOrCreate(['name' => 'delete_hubins']);

        // Alumni Management
        Permission::firstOrCreate(['name' => 'view_alumnis']);
        Permission::firstOrCreate(['name' => 'create_alumnis']);
        Permission::firstOrCreate(['name' => 'edit_alumnis']);
        Permission::firstOrCreate(['name' => 'delete_alumnis']);

        // Kontak Management
        Permission::firstOrCreate(['name' => 'view_kontaks']);
        Permission::firstOrCreate(['name' => 'create_kontaks']);
        Permission::firstOrCreate(['name' => 'edit_kontaks']);
        Permission::firstOrCreate(['name' => 'delete_kontaks']);

        // PPDB Management
        Permission::firstOrCreate(['name' => 'view_ppdbs']);
        Permission::firstOrCreate(['name' => 'create_ppdbs']);
        Permission::firstOrCreate(['name' => 'edit_ppdbs']);
        Permission::firstOrCreate(['name' => 'delete_ppdbs']);

        // PPDB Info Management
        Permission::firstOrCreate(['name' => 'view_ppdbinfos']);
        Permission::firstOrCreate(['name' => 'create_ppdbinfos']);
        Permission::firstOrCreate(['name' => 'edit_ppdbinfos']);
        Permission::firstOrCreate(['name' => 'delete_ppdbinfos']);

        // Galeri Management
        Permission::firstOrCreate(['name' => 'view_galeris']);
        Permission::firstOrCreate(['name' => 'create_galeris']);
        Permission::firstOrCreate(['name' => 'edit_galeris']);
        Permission::firstOrCreate(['name' => 'delete_galeris']);

        // Chat Management
        Permission::firstOrCreate(['name' => 'view_chats']);
        Permission::firstOrCreate(['name' => 'create_chats']);
        Permission::firstOrCreate(['name' => 'edit_chats']);
        Permission::firstOrCreate(['name' => 'delete_chats']);



        // Create roles and assign permissions
        //  $adminRole = Role::create(['name' => 'admin']);
        // $adminRole->givePermissionTo(Permission::all());
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        //  $guruRole = Role::create(['name' => 'guru']);
        // $guruRole->givePermissionTo([
        $guruRole = Role::firstOrCreate(['name' => 'guru']);
        $guruRole->syncPermissions([
            'view_siswas',
            'view_kelas',
            'view_jurusans',
            'view_beritas',
            'view_ekstrakurikulers',
            'view_fasilitas',
        ]);

        //  $siswaRole = Role::create(['name' => 'siswa']);
        // $siswaRole->givePermissionTo([
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);
        $siswaRole->syncPermissions([
            'view_beritas',
            'view_ekstrakurikulers',
            'view_fasilitas',
        ]);
    }
} 