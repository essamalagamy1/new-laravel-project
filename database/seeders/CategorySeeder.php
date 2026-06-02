<?php

namespace Database\Seeders;

use App\Actions\Media\GenerateRandomImageAction;
use App\Enums\Status;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(GenerateRandomImageAction $action): void
    {
        // Main Categories - Course Categories
        $programming = Category::create([
            'name' => ['en' => 'Programming & Development', 'ar' => 'البرمجة والتطوير'],
            'status' => Status::Active,
        ]);
        $design = Category::create([
            'name' => ['en' => 'Design & Multimedia', 'ar' => 'التصميم والوسائط المتعددة'],
            'status' => Status::Active,
        ]);
        $business = Category::create([
            'name' => ['en' => 'Business & Management', 'ar' => 'الأعمال والإدارة'],
            'status' => Status::Active,
        ]);
        $marketing = Category::create([
            'name' => ['en' => 'Marketing & Sales', 'ar' => 'التسويق والمبيعات'],
            'status' => Status::Active,
        ]);
        $languages = Category::create([
            'name' => ['en' => 'Languages', 'ar' => 'اللغات'],
            'status' => Status::Active,
        ]);
        $health = Category::create([
            'name' => ['en' => 'Health & Fitness', 'ar' => 'الصحة واللياقة البدنية'],
            'status' => Status::Active,
        ]);
        $music = Category::create([
            'name' => ['en' => 'Music & Arts', 'ar' => 'الموسيقى والفنون'],
            'status' => Status::Active,
        ]);
        $academics = Category::create([
            'name' => ['en' => 'Academic Subjects', 'ar' => 'المواد الأكاديمية'],
            'status' => Status::Active,
        ]);
        $lifestyle = Category::create([
            'name' => ['en' => 'Lifestyle & Personal Development', 'ar' => 'أسلوب الحياة والتنمية الشخصية'],
            'status' => Status::Active,
        ]);
        $photography = Category::create([
            'name' => ['en' => 'Photography & Video', 'ar' => 'التصوير والفيديو'],
            'status' => Status::Active,
        ]);
        $technology = Category::create([
            'name' => ['en' => 'Information Technology', 'ar' => 'تكنولوجيا المعلومات'],
            'status' => Status::Active,
        ]);
        $science = Category::create([
            'name' => ['en' => 'Science & Engineering', 'ar' => 'العلوم والهندسة'],
            'status' => Status::Active,
        ]);
        $finance = Category::create([
            'name' => ['en' => 'Finance & Accounting', 'ar' => 'المالية والمحاسبة'],
            'status' => Status::Active,
        ]);
        $teaching = Category::create([
            'name' => ['en' => 'Teaching & Education', 'ar' => 'التدريس والتعليم'],
            'status' => Status::Active,
        ]);
        $cooking = Category::create([
            'name' => ['en' => 'Cooking & Culinary Arts', 'ar' => 'الطبخ وفنون الطهي'],
            'status' => Status::Active,
        ]);
        // Subcategories for Programming & Development
        Category::create([
            'parent_id' => $programming->id,
            'name' => ['en' => 'Web Development', 'ar' => 'تطوير المواقع'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $programming->id,
            'name' => ['en' => 'Mobile App Development', 'ar' => 'تطوير تطبيقات الهاتف'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $programming->id,
            'name' => ['en' => 'Data Science', 'ar' => 'علوم البيانات'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $programming->id,
            'name' => ['en' => 'Artificial Intelligence', 'ar' => 'الذكاء الاصطناعي'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $programming->id,
            'name' => ['en' => 'Game Development', 'ar' => 'تطوير الألعاب'],
            'status' => Status::Active,
        ]);
        // Subcategories for Design & Multimedia
        Category::create([
            'parent_id' => $design->id,
            'name' => ['en' => 'Graphic Design', 'ar' => 'التصميم الجرافيكي'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $design->id,
            'name' => ['en' => 'UI/UX Design', 'ar' => 'تصميم واجهات المستخدم'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $design->id,
            'name' => ['en' => '3D Animation', 'ar' => 'الرسوم المتحركة ثلاثية الأبعاد'],
            'status' => Status::Active,
        ]);
        // Subcategories for Business & Management
        Category::create([
            'parent_id' => $business->id,
            'name' => ['en' => 'Project Management', 'ar' => 'إدارة المشاريع'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $business->id,
            'name' => ['en' => 'Leadership', 'ar' => 'القيادة'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $business->id,
            'name' => ['en' => 'Entrepreneurship', 'ar' => 'ريادة الأعمال'],
            'status' => Status::Active,
        ]);
        // Subcategories for Marketing & Sales
        Category::create([
            'parent_id' => $marketing->id,
            'name' => ['en' => 'Digital Marketing', 'ar' => 'التسويق الرقمي'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $marketing->id,
            'name' => ['en' => 'Social Media Marketing', 'ar' => 'تسويق وسائل التواصل الاجتماعي'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $marketing->id,
            'name' => ['en' => 'Content Marketing', 'ar' => 'تسويق المحتوى'],
            'status' => Status::Active,
        ]);
        // Subcategories for Languages
        Category::create([
            'parent_id' => $languages->id,
            'name' => ['en' => 'English Language', 'ar' => 'اللغة الإنجليزية'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $languages->id,
            'name' => ['en' => 'Arabic Language', 'ar' => 'اللغة العربية'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $languages->id,
            'name' => ['en' => 'French Language', 'ar' => 'اللغة الفرنسية'],
            'status' => Status::Active,
        ]);
        Category::create([
            'parent_id' => $languages->id,
            'name' => ['en' => 'German Language', 'ar' => 'اللغة الألمانية'],
            'status' => Status::Active,
        ]);

        Category::query()->cursor()->each(fn (Category $category) => $action->executeSvg($category));
    }
}
