<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles if they don't exist
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $guru = Role::firstOrCreate(['name' => 'guru']);
        $siswa = Role::firstOrCreate(['name' => 'siswa']);

        // Assign permissions to roles
        $admin->givePermissionTo([
            'view_dashboard',
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
            'view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions',
            'view_sekolahs', 'create_sekolahs', 'edit_sekolahs', 'delete_sekolahs',
            'view_settings', 'create_settings', 'edit_settings', 'delete_settings',
            'view_jurusans', 'create_jurusans', 'edit_jurusans', 'delete_jurusans',
            'view_kelas', 'create_kelas', 'edit_kelas', 'delete_kelas',
            'view_ptks', 'create_ptks', 'edit_ptks', 'delete_ptks',
            'view_siswas', 'create_siswas', 'edit_siswas', 'delete_siswas',
            'view_beritas', 'create_beritas', 'edit_beritas', 'delete_beritas',
            'view_fasilitas', 'create_fasilitas', 'edit_fasilitas', 'delete_fasilitas',
            'view_ekstrakurikulers', 'create_ekstrakurikulers', 'edit_ekstrakurikulers', 'delete_ekstrakurikulers',
            'view_hubins', 'create_hubins', 'edit_hubins', 'delete_hubins',
            'view_infaqs', 'create_infaqs', 'edit_infaqs', 'delete_infaqs',
            'view_sliders', 'create_sliders', 'edit_sliders', 'delete_sliders',
            'view_galeris', 'create_galeris', 'edit_galeris', 'delete_galeris',
            'view_kontaks', 'create_kontaks', 'edit_kontaks', 'delete_kontaks',
            'view_ppdbs', 'create_ppdbs', 'edit_ppdbs', 'delete_ppdbs',
            'view_ppdbinfos', 'create_ppdbinfos', 'edit_ppdbinfos', 'delete_ppdbinfos',
            'view_alumnis', 'create_alumnis', 'edit_alumnis', 'delete_alumnis',
        ]);

        $guru->givePermissionTo([
            'view_dashboard',
            'view_siswas',
            'view_jurusans',
            'view_kelas',
            'view_beritas',
            'view_fasilitas',
            'view_ekstrakurikulers',
            'view_hubins',
        ]);

        $siswa->givePermissionTo([
            'view_dashboard',
            'view_beritas',
            'view_fasilitas',
            'view_ekstrakurikulers',
            'view_hubins',
        ]);
    }
} 