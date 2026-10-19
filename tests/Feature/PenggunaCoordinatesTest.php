<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenggunaCoordinatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_pelanggan_with_coordinates(): void
    {
        $admin = User::create([
            'nama' => 'Admin Test',
            'username' => 'admintest',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.pengguna.store'), [
            'nama' => 'Pak Tani Joko',
            'username' => 'jokotani',
            'password' => 'password123',
            'role' => 'pelanggan',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Sawah Subur No. 10',
            'latitude' => '-7.546835',
            'longitude' => '112.226512',
        ]);

        $response->assertRedirect(route('admin.pengguna.index'));
        $this->assertDatabaseHas('user', [
            'username' => 'jokotani',
            'role' => 'pelanggan',
            'latitude' => '-7.546835',
            'longitude' => '112.226512',
        ]);
    }

    public function test_admin_can_update_pelanggan_coordinates(): void
    {
        $admin = User::create([
            'nama' => 'Admin Test',
            'username' => 'admintest',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $pelanggan = User::create([
            'nama' => 'Pelanggan Lama',
            'username' => 'pelangganlama',
            'password' => 'password123',
            'role' => 'pelanggan',
            'no_hp' => '081111111111',
            'alamat' => 'Alamat Awal',
            'latitude' => '-7.100000',
            'longitude' => '112.100000',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.pengguna.update', $pelanggan->id), [
            'nama' => 'Pelanggan Diperbarui',
            'username' => 'pelangganlama',
            'role' => 'pelanggan',
            'no_hp' => '082222222222',
            'alamat' => 'Alamat Baru',
            'latitude' => '-7.555555',
            'longitude' => '112.333333',
        ]);

        $response->assertRedirect(route('admin.pengguna.index'));
        $this->assertDatabaseHas('user', [
            'id' => $pelanggan->id,
            'nama' => 'Pelanggan Diperbarui',
            'latitude' => '-7.555555',
            'longitude' => '112.333333',
        ]);
    }

    public function test_checkout_order_form_displays_store_coordinates_and_maps(): void
    {
        $response = $this->get(route('checkout'));

        $response->assertStatus(200);
        $response->assertSee('Titik Koordinat Toko');
        $response->assertSee(config('simantap.store_latitude'));
        $response->assertSee(config('simantap.store_longitude'));
        $response->assertSee('map-toko');
        $response->assertSee('map-pelanggan');
    }
}
