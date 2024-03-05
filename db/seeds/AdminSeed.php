<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AdminSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name'    => 'foo',
                'login' => 'admin',
                'password'=>'$2y$10$R3PJRP2RGC0rHwrThupCfeh.Zv9SXsEbmvms6rh0dvECemG.0AWOC',
                'is_active'=>true,
                'component'=>'Admin'
            ],
        ];

        $posts = $this->table('main_user');
        $posts->insert($data)
            ->saveData();
    }
}
