<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class IndexArticleSeed extends AbstractSeed
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
                'title'    => 'Home',
                'text' => '<p>Welcome to LiraCMS !!!</p>',
            ],
        ];

        $posts = $this->table('web_articles');
        $posts->insert($data)
            ->saveData();
    }
}
