<?php

namespace Database\Seeders;

use App\Actions\Media\GenerateRandomImageAction;
use App\Enums\Status;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(GenerateRandomImageAction $action): void
    {

        $banners = [
            [
                'name' => [
                    'ar' => 'خصم خاص على كورسات البرمجة',
                    'en' => 'Special Discount on Programming Courses',
                ],
                'description' => [
                    'ar' => 'احصل على خصم يصل إلى 50% على جميع كورسات البرمجة والتطوير',
                    'en' => 'Get up to 50% discount on all programming and development courses',
                ],
                'status' => Status::Active,
            ],
            [
                'name' => [
                    'ar' => 'كورسات جديدة في الذكاء الاصطناعي',
                    'en' => 'New AI & Machine Learning Courses',
                ],
                'description' => [
                    'ar' => 'اكتشف أحدث كورسات الذكاء الاصطناعي وتعلم الآلة من الخبراء',
                    'en' => 'Discover the latest AI and machine learning courses from industry experts',
                ],
                'status' => Status::Active,
            ],
            [
                'name' => [
                    'ar' => 'عروض نهاية السنة الدراسية',
                    'en' => 'End of Academic Year Sale',
                ],
                'description' => [
                    'ar' => 'تخفيضات هائلة على جميع الكورسات - لفترة محدودة فقط',
                    'en' => 'Huge discounts on all courses - Limited time offer only',
                ],
                'status' => Status::Active,
            ],
            [
                'name' => [
                    'ar' => 'كورسات التصميم والجرافيك',
                    'en' => 'Design & Graphics Courses',
                ],
                'description' => [
                    'ar' => 'تعلم فنون التصميم الجرافيكي والويب مع خبراء المجال',
                    'en' => 'Learn graphic and web design arts with industry professionals',
                ],
                'status' => Status::Active,
            ],
            [
                'name' => [
                    'ar' => 'كورسات إدارة الأعمال الرقمية',
                    'en' => 'Digital Business Management Courses',
                ],
                'description' => [
                    'ar' => 'طور مهاراتك في إدارة الأعمال الرقمية والتسويق الإلكتروني',
                    'en' => 'Develop your skills in digital business management and e-marketing',
                ],
                'status' => Status::Inactive,
            ],
        ];

        foreach ($banners as $banner) {
            $banner = Banner::create($banner);
            $action->execute($banner, 'image');
        }

    }
}
