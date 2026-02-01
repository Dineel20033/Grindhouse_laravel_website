<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class UpdateCategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update the image for a specific category (e.g., first category)
        $category = Category::first();
        if ($category) {
            $category->image = 'assets/myimage.jpg'; // Change to your desired image path or URL
            $category->save();
            $this->command->info('Category image updated successfully.');
        } else {
            $this->command->info('No category found to update.');
        }
    }
}
