<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define dummy data
        $posts = [
            [
                'title' => 'What is Vue?',
                'body' => 'Vue.js is a progressive JavaScript framework used for building user interfaces and single-page applications. Its core library focuses on the view layer, making it easy to integrate with other libraries or existing projects. Vue is component-based architecture allows developers to encapsulate and reuse code, enhancing maintainability and scalability. With its reactive data binding and virtual DOM, Vue ensures high performance and a responsive user experience. Additionally, its robust ecosystem, including tools like Vue CLI, Vue Router, and Vuex, provides comprehensive support for development, routing, and state management, making Vue.js a versatile and powerful choice for modern web development.',
                'user_id' => 1, // Assuming user with ID 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'What is Laravel?',
                'body' => 'Laravel is a powerful and elegant PHP framework designed to streamline the web development process. It follows the Model-View-Controller (MVC) architectural pattern, ensuring a clear separation of logic and presentation. Laravel offers a rich set of features including an expressive ORM called Eloquent, a robust routing system, integrated authentication and authorization, and a powerful task scheduling system. Its modular packaging system and built-in tools like Laravel Artisan CLI enhance productivity and maintainability. Laravel focus on simplicity, elegance, and readability makes it a preferred choice for developers aiming to build modern, scalable, and secure web applications efficiently.',
                'user_id' => 2, // Assuming user with ID 2 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more dummy posts as needed
        ];

        // Insert data into the 'posts' table
        DB::table('posts')->insert($posts);
    }
}
