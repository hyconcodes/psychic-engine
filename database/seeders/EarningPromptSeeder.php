<?php

namespace Database\Seeders;

use App\Models\EarningPrompt;
use Illuminate\Database\Seeder;

class EarningPromptSeeder extends Seeder
{
    public function run(): void
    {
        $prompts = [
            ['sentence', 'yo', 'Ẹ káàárọ̀ o, ẹ káàbọ̀ sí VocalPay.'],
            ['sentence', 'yo', 'Mo fẹ́ kọ́ ọ̀pọ̀lọpọ̀ nínú èdè Yorùbá.'],
            ['word', 'yo', 'àlàáfíà'],
            ['word', 'yo', 'ọmọ'],
            ['word', 'yo', 'orúkọ'],

            ['sentence', 'ha', 'Ina kwana, barka da zuwa VocalPay.'],
            ['sentence', 'ha', 'Ina son koyon harshen Hausa sosai.'],
            ['word', 'ha', 'lafiya'],
            ['word', 'ha', 'ruwa'],
            ['word', 'ha', 'gida'],

            ['sentence', 'ig', 'Ụtụtụ ọma, nnabata na VocalPay.'],
            ['sentence', 'ig', 'Achọrọ m ịmụ asụsụ Igbo nke ọma.'],
            ['word', 'ig', 'ụlọ'],
            ['word', 'ig', 'mmiri'],
            ['word', 'ig', 'nwa'],

            ['sentence', 'pcm', 'Good morning, welcome to VocalPay.'],
            ['sentence', 'pcm', 'I wan learn many things for VocalPay.'],
            ['word', 'pcm', 'chop'],
            ['word', 'pcm', 'waka'],
            ['word', 'pcm', 'wahala'],

            ['sentence', 'zu', 'Sawubona, wamukelekile kuVocalPay.'],
            ['sentence', 'zu', 'Ngifuna ukufunda isiZulu kakhulu.'],
            ['word', 'zu', 'amanzi'],
            ['word', 'zu', 'indlu'],
            ['word', 'zu', 'umntwana'],

            ['sentence', 'ar', 'صباح الخير، مرحباً بكم في VocalPay.'],
            ['sentence', 'ar', 'أريد أن أتعلم اللغة العربية جيداً.'],
            ['word', 'ar', 'سلام'],
            ['word', 'ar', 'ماء'],
            ['word', 'ar', 'بيت'],

            ['sentence', 'sw', 'Habari za asubuhi, karibu VocalPay.'],
            ['sentence', 'sw', 'Ninataka kujifunza Kiswahili vizuri.'],
            ['word', 'sw', 'maji'],
            ['word', 'sw', 'nyumba'],
            ['word', 'sw', 'mtoto'],
        ];

        foreach ($prompts as [$type, $language, $text]) {
            EarningPrompt::firstOrCreate([
                'type' => $type,
                'language' => $language,
                'text' => $text,
            ], [
                'is_active' => true,
            ]);
        }
    }
}
