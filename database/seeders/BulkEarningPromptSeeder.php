<?php

namespace Database\Seeders;

use App\Models\EarningPrompt;
use Illuminate\Database\Seeder;

class BulkEarningPromptSeeder extends Seeder
{
    public function run(): void
    {
        EarningPrompt::query()->delete();

        $allPrompts = array_merge(
            $this->yorubaPrompts(),
            $this->hausaPrompts(),
            $this->igboPrompts(),
            $this->pidginPrompts(),
            $this->zuluPrompts(),
            $this->arabicPrompts(),
            $this->swahiliPrompts(),
        );

        foreach ($allPrompts as $prompt) {
            EarningPrompt::create($prompt);
        }

        $this->command->info('Seeded '.count($allPrompts).' earning prompts across 7 languages.');
    }

    private function yorubaPrompts(): array
    {
        return $this->buildPrompts('yo', [
            'greetings' => [
                'easy' => [
                    'Bawo ni',
                    'E kaaro',
                    'E ku irole',
                    'O dabọ',
                    'Mo wa',
                    'O ni irọlẹ',
                    'Bawo ni o wa',
                    'Ẹ kú àárọ̀',
                ],
                'medium' => [
                    'Ṣé ọ̀ṣẹ̀ yín la pẹ̀',
                    'Kí a bá ń bá ọ̀rọ̀ sọ',
                    'Ṣé irin-ajo rẹ ti parí',
                    'Mo fẹ́ láti bá ọ sọ̀rọ̀',
                    'Kí ọ̀run yín dára',
                    'Mo n dúpẹ́ fún ọ̀pọ̀ ohun',
                ],
                'hard' => [
                    'Bí a bá ń bá ọ̀dá ń bọ̀, a yóò bá ìmọ̀lẹ̀ rí',
                    'Ọmọdé tí kò bá ń kọ́ ohunkóhun kò ní rí ìmọ̀lẹ̀',
                    'Àgbàlagbà tí ó bá n tọ́ka sí ọ̀rọ̀ tí kò sí náà, ọ̀rọ̀ rẹ̀ yóò jẹ́',
                    'Irú ọmọ tí ìyá rẹ̀ bá kan, ìyá rẹ̀ yóò jẹ́ pàtàkì fún un',
                ],
            ],
            'food' => [
                'easy' => [
                    'Jẹun',
                    'Mi omi',
                    'Jẹ ẹja',
                    'Jẹ ẹ̀dá',
                    'Mo fẹ́ jẹun',
                    'Omi ga',
                ],
                'medium' => [
                    'Jẹun tí mo ṣe dára púpọ̀',
                    'Mi omi tuntun ti o ga',
                    'Mo fẹ́ jẹun ti a mú síbi',
                    'Jẹ ẹja tí a mẹ́ sílẹ̀',
                ],
                'hard' => [
                    'Jẹun tí ìyá rẹ̀ ṣe ní àbẹ́yẹ́yẹ́ jù lọ ní ilé',
                    'A bá jẹun pẹ̀lú àwọn ọmọde tí ó wa ní àdúgbò',
                    'Jẹun tí ó ní ìdùn tí kò sí ipá rẹ̀ sílẹ̀',
                ],
            ],
            'travel' => [
                'easy' => [
                    'Mo ń lọ',
                    'Mo ń bọ̀',
                    'Mo ti dé',
                    'Irin-ajo dára',
                    'Mo fẹ́ lọ ilé',
                ],
                'medium' => [
                    'Mo ń lọ sí ọ̀nà tí ó pọ̀',
                    'Irin-ajo yìí jinlẹ̀ púpọ̀ fún mi',
                    'Mo ti kọ̀sí ibì tí mo fẹ́ lọ',
                    'Ó dára gan-an fún mi láti lọ',
                ],
                'hard' => [
                    'Irin-ajo tí a bá ń lọ sí ibì tí kò sí ẹnikẹ́ni, ọ̀pọ̀ ohun yóò sì ṣẹlẹ̀',
                    'Bí a bá ń lọ sí ọ̀nà tí kò sí ẹ̀dá, a yóò bá ìṣòro pàdé',
                    'Irin-ajo tí ó bá ń lọ ní àkókò yìí, a yóò rí ìmọ̀lẹ̀ rí',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'Okan',
                    'Ejì',
                    'Meta',
                    'Merin',
                    'Marun-un',
                    'Mẹ́fà',
                    'Méje',
                    'Mẹ́jọ',
                    'Mẹ́sàn-àn',
                    'Mẹ́wàá',
                ],
                'medium' => [
                    'Ọ̀kẹ́ kan',
                    'Ọ̀kẹ́ méjì',
                    'Ọ̀kẹ́ mọ́ta',
                    'Ọ̀kẹ́ mérin',
                    'Ọ̀kẹ́ marun-un',
                ],
                'hard' => [
                    'Ọ̀kẹ́ mọ́ka-ọ̀ọ́dún-ún-lágbàá-kan',
                    'Ọ̀kẹ́ mọ́ka-ọ̀ọ́dún-ún-lágbàá-méjì',
                    'Ọ̀kẹ́ mọ́ka-ọ̀ọ́dún-ún-lágbàá-meta',
                    'Ọ̀kẹ́ mọ́ka-ọ̀ọ́dún-ún-lágbàá-merin',
                    'Ọ̀kẹ́ mọ́ka-ọ̀ọ́dún-ún-lágbàá-marun-un',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Ẹ ṣé',
                    'Jọ̀wọ́',
                    'Bẹ̀ẹ̀ni',
                    'Rárá',
                    'Ó dára',
                ],
                'medium' => [
                    'Mo dúpẹ́ sí Ọlọ́run fún ohun gbogbo',
                    'Kí Ọlọ́run ìrètí yín bá',
                    'Mo fẹ́ kí a bá ń jọwọ́ pọ̀',
                    'Ìyàkan ni ọ̀pọ̀ ohun gbogbo yóò parí',
                ],
                'hard' => [
                    'Bí a bá ń gbé Ọlọ́run ga, a yóò rí ìmọ̀lẹ̀ rí ní ìgbà gbogbo',
                    'Àwọn tí ń bá ń ṣe ìdájọ́ sílẹ̀ yóò rí ìbẹ̀rù pẹ̀lú',
                    'Kò sí ohun tí Ọlọ́run kò ṣe lè ṣe fún àwọn tí ó bá n bọ̀wọ̀ fún un',
                ],
            ],
            'family' => [
                'easy' => [
                    'Bàbá mi',
                    'Ìyá mi',
                    'Ọmọ mi',
                    'Ará mi',
                    'Ẹ̀bí mi',
                ],
                'medium' => [
                    'Bàbá mi ń ṣiṣẹ́ ní ilé-iṣẹ́',
                    'Ìyá mi jẹ́ àgbà fún mi',
                    'Ọmọ mi ń kọ́wé gan-an',
                    'Ará ilé mi jọba pọ̀',
                ],
                'hard' => [
                    'Àwọn tí ń bá á ilé wa pọ̀ jẹ́ àwọn tí a fẹ́ran gan-an',
                    'Ẹ̀bí tí a bá n bá pọ̀ jọ́, a yóò lè fi hàn pé a jẹ́ irú ìkan',
                    'Bàbá tí ó bá ń kọ́ ọmọ rẹ̀ ní ọ̀rọ̀, ọmọ rẹ̀ yóò jẹ́ omi ìrètí',
                ],
            ],
            'work' => [
                'easy' => [
                    'Mo ń ṣiṣẹ́',
                    'Iṣẹ́ dára',
                    'Mo fẹ́ iṣẹ́',
                    'Omi iṣẹ́',
                ],
                'medium' => [
                    'Iṣẹ́ tí mo ń ṣe jẹ́ pàtàkì fún ilé',
                    'Mo fẹ́ láti bá iṣẹ́ tuntun',
                    'Iṣẹ́ tí a bá ń ṣe pọ̀ jọ́, a yóò rí ohun dára',
                    'Mo ní àbá nilẹ̀ tí mo fẹ́ láti fi ṣiṣẹ́',
                ],
                'hard' => [
                    'Iṣẹ́ tí ọ̀pọ̀ ènìyàn bá ń ṣe pọ̀ jọ́, a yóò rí àlàáfíà',
                    'Bí a bá ń ṣiṣẹ́ pẹ̀lú ọkàn détí, a yóò rí ìbùkún',
                    'Iṣẹ́ tí a bá ń ṣe fún àwọn ènìyàn, Ọlọ́run yóò bá àlàáfíà pè',
                ],
            ],
        ]);
    }

    private function hausaPrompts(): array
    {
        return $this->buildPrompts('ha', [
            'greetings' => [
                'easy' => [
                    'Sannu',
                    'Barka da safe',
                    'Barka da yamma',
                    'Lafiya lau',
                    'Yaya kuke',
                    'Na gode',
                    'Sai an jima',
                    'Lafiya',
                ],
                'medium' => [
                    'Yaya kuka yi aiki',
                    'Lafiya lau da wata',
                    ' Barka da sabuwar rana',
                    'Ina son in yi magana da ku',
                    'Yaya kuke wata',
                ],
                'hard' => [
                    'Mutane masu hankali suna irin mutanen da suka sani',
                    'Yadda ake yi aiki yana da muhimmanci ga kowane mutum',
                    'Ni da kuna kai mu bai dace ba a yi magana',
                ],
            ],
            'food' => [
                'easy' => [
                    'Ci abinci',
                    'Sha ruwa',
                    'Ci kifi',
                    'Ci nama',
                    'Ina son cin abinci',
                    'Ruwa mai sanyi',
                ],
                'medium' => [
                    'Abincin da na yi yana da daɗi sosai',
                    'Sha ruwa mai sanyi yana da lafiya',
                    'Ina son ci abincin da aka yi a waje',
                    'Ci kifi da wake',
                ],
                'hard' => [
                    'Abincin da mahaifiyar ta yi yana da ɗanɗano mai kyau sosai',
                    'Ci abinci tare da abokansa yana da kyau a karkara',
                    'Abincin da aka yi da kayan kwalliya yana da wari daɗi',
                ],
            ],
            'travel' => [
                'easy' => [
                    'Ina tafiya',
                    'Zan kai',
                    'Na zo',
                    'Tafiya mai kyau',
                    'Ina son tafiya',
                ],
                'medium' => [
                    'Tafiyar da na yi tana da tsawo sosai',
                    'Na tafi cankume a cikin yau',
                    'Ina son tafiya zuwa wata ƙasa',
                    'Tafiya mai daɗi',
                ],
                'hard' => [
                    'Tafiyar da mutane ke yi zuwa wata ƙasa yana da ban sha\'awa',
                    'Idan an tafi tare da abokansa, tafiya tana da ban haɗi',
                    'Tafiyar da za ta kai inda za a sani yana da amfani',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'Daya',
                    'Biyu',
                    'Uku',
                    'Huɗu',
                    'Biyar',
                    'Shidda',
                    'Bakwai',
                    'Takwas',
                    'Tara',
                    'Goma',
                ],
                'medium' => [
                    'Din ɗaya',
                    'Din biyu',
                    'Din uku',
                    'Din huɗu',
                    'Din biyar',
                ],
                'hard' => [
                    'Din shekara ɗaya',
                    'Din shekara biyu',
                    'Din shekara uku',
                    'Din shekara huɗu',
                    'Din shekara biyar',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Na gode',
                    'Daɗɗanko',
                    'Eh',
                    'A\'a',
                    'To',
                ],
                'medium' => [
                    'Na gode da kyauwarku',
                    'Zan yi gwadawa',
                    'Allah ya sa ya dace',
                    'Ni da ku zan yi aiki tare',
                ],
                'hard' => [
                    'Idan an yi aiki tare, za a samu nasara',
                    'Mutane masu hankali suna irin mutanen da suka sani',
                    'Abin da ke faruwa yana da ma\'ana',
                ],
            ],
            'family' => [
                'easy' => [
                    'Uba na',
                    'Ummah na',
                    'Ya\'ya na',
                    'Iyali na',
                    'Abokina',
                ],
                'medium' => [
                    'Uban na yana aiki a ofis',
                    'Ummah na tana koyarwa',
                    'Ya\'yan na suna karatu',
                    'Iyali nawa yana jima',
                ],
                'hard' => [
                    'Iyali da ke ci gaba da haɗuwa yana da ban sha\'awa',
                    'Uba da Ummah suna taimaka wa Ya\'ya su',
                    'Abokansa suna taimaka wa ya ci gaba',
                ],
            ],
            'work' => [
                'easy' => [
                    'Na yi aiki',
                    'Aiki yana da kyau',
                    'Ina son aiki',
                    'Ran aiki',
                ],
                'medium' => [
                    'Aikin da na yi yana da amfani',
                    'Ina son aiki tare da ku',
                    'Aiki yana da muhimmanci',
                    'Na yi aiki da wuri',
                ],
                'hard' => [
                    'Aikin da mutane ke yi yana da tasiri ga al\'umma',
                    'Idan an yi aiki da hankali, za a samu nasara',
                    'Aikin da ke taimaka wa mutane yana da kyau',
                ],
            ],
        ]);
    }

    private function igboPrompts(): array
    {
        return $this->buildPrompts('ig', [
            'greetings' => [
                'easy' => [
                    'Ndewo',
                    'Mma na abịa',
                    'Kedu ka ị mee',
                    'Daalụ',
                    'Ka ọ dị',
                    'Ezigbo ehihie',
                    'Ezigbo abali',
                    'Nnọọ',
                ],
                'medium' => [
                    'Kedu ka ị si nọ',
                    'Daalụ nke ukwuu',
                    'M ga-asị ka ịnụ',
                    'Chọrọ m ka m sị gị',
                    'Ka ọ chere gị',
                ],
                'hard' => [
                    'Ndi na-eche ndụ ga-eche ndụ',
                    'Ndi na-azụ ahịa ga-enwe ndụ',
                    'Ka anyị na-eche otu anyị si na-eche ndụ',
                ],
            ],
            'food' => [
                'easy' => [
                    'Rie nri',
                    'Nụ mmiri',
                    'Rie azụ',
                    'Rie anụ',
                    'A na m agha iri nri',
                    'Mmiri sụsụ',
                ],
                'medium' => [
                    'Nri m na-esi nke ahụ na-adọrọ mmasị',
                    'Nụ mmiri sụsụ na-enye afọ mma',
                    'A na m agha iri nri a na-akụziri n\'ụlọ',
                    'Rie azụ na akwụkwọ',
                ],
                'hard' => [
                    'Nri nne m na-esi nke ahụ na-adọrọ mmasị nke ukwuu',
                    'Iri nri na ndị enyi m na-enye afọ mma',
                    'Nri a na-esi na ntụgharị na-enye ụtọ dị iche',
                ],
            ],
            'travel' => [
                'easy' => [
                    'A na m aga',
                    'M ga-atọ',
                    'M dọrọala',
                    'Ụzọ dị mma',
                    'A na m agha aga',
                ],
                'medium' => [
                    'A ghọgharịrị m n\'ụzọ dị nro',
                    'M ga-asị ka m ga-eje',
                    'A na m agha aga ebe m chọrọ',
                    'Agha ahụ na-adọrọ mmasị',
                ],
                'hard' => [
                    'Ihe a ga-ahụ na-agwa ha na ọ ga-adị mma',
                    'Ị ga-eje n\'ụzọ a ga-agwa gị ka ị rie nri',
                    'A na-eche ndụ n\'ụzọ a na-achọsi ihe',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'Otú',
                    'Abụọ',
                    'Atọ',
                    'Anọ',
                    'Ise',
                    'Isii',
                    'Asaa',
                    'Asatọ',
                    'Ametọ',
                    'Iri',
                ],
                'medium' => [
                    'Nke otu',
                    'Nke abụọ',
                    'Nke atọ',
                    'Nke anọ',
                    'Nke ise',
                ],
                'hard' => [
                    'Nke afọ otu',
                    'Nke afọ abụọ',
                    'Nke afọ atọ',
                    'Nke afọ anọ',
                    'Nke afọ ise',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Daalụ',
                    'Mma',
                    'Ee',
                    'Mba',
                    'Ọ dị mma',
                ],
                'medium' => [
                    'Daalụ nke ukwuu',
                    'M ga-agwa gị ka ị nụ',
                    'Chọrọ m ka m sị gị',
                    'Ka anyị na-ekwurịta okwu',
                ],
                'hard' => [
                    'Ihe a ga-ahụ na-agwa ha na ọ ga-adị mma',
                    'Ndi na-eche ndụ ga-eche ndụ',
                    'Ihe a na-ahụ na-enye ndụ ọhụrụ',
                ],
            ],
            'family' => [
                'easy' => [
                    'Nna m',
                    'Nne m',
                    'Nwa m',
                    'Ụmụ m',
                    'Ndi n\'ụlọ m',
                ],
                'medium' => [
                    'Nna m na-arụsi ọrụ',
                    'Nne m na-akụziri',
                    'Nwa m na-agụ akwụkwọ',
                    'Ụmụ m na-enwe mma',
                ],
                'hard' => [
                    'Ụmụ nke a na-eche ndụ na-eme ndụ ka ọ dị mma',
                    'Nna na Nne na-enye ndụ ọhụrụ',
                    'Ndi n\'ụlọ na-enye ndụ ka ọ dị mma',
                ],
            ],
            'work' => [
                'easy' => [
                    'A na m arụsi ọrụ',
                    'Ọrụ dị mma',
                    'A na m agha ọrụ',
                    'Ehihie ọrụ',
                ],
                'medium' => [
                    'Ọrụ m na-arụsi na-enye ndụ ọhụrụ',
                    'A na m agha ọrụ ọnụ',
                    'Ọrụ na-adị mma',
                    'A na m arụsi ọrụ na-ọkwa',
                ],
                'hard' => [
                    'Ọrụ a na-arụsi na-enye ndụ ọhụrụ',
                    'Ihe a ga-ahụ na-agwa ha na ọ ga-adị mma',
                    'Ọrụ a na-akụziri na-enye ndụ ọhụrụ',
                ],
            ],
        ]);
    }

    private function pidginPrompts(): array
    {
        return $this->buildPrompts('pcm', [
            'greetings' => [
                'easy' => [
                    'How far',
                    'Wetin dey happen',
                    'How you dey',
                    'I dey kampe',
                    'Wahala no dey',
                    'How body',
                    'No wahala',
                    'I dey snap',
                ],
                'medium' => [
                    'How you take dey for house',
                    'Wetin you dey do for work',
                    'How life treat you',
                    'You don chop',
                    'I dey find where I go fit relax',
                ],
                'hard' => [
                    'Wetin dey happen for this country, na wa o',
                    'How you take manage for this economy wey dey tough',
                    'Person wey no get money no fit talk',
                ],
            ],
            'food' => [
                'easy' => [
                    'I wan chop',
                    'Give me water',
                    'I wan drink',
                    'Food don ready',
                    'I dey hungry',
                    'Water dey cold',
                ],
                'medium' => [
                    'This food wey you cook sweet well well',
                    'I wan drink cold water well well',
                    'I wan chop where dem dey sell am',
                    'Food wey dem cook for village dey nice',
                ],
                'hard' => [
                    'The food wey mama cook for house sweet pass any food wey you fit buy outside',
                    'When we dey eat together, e dey make person happy well well',
                    'Food wey you prepare yourself dey better pass the one wey dem serve you',
                ],
            ],
            'travel' => [
                'easy' => [
                    'I wan go',
                    'I don reach',
                    'I dey come',
                    'Road dey clear',
                    'I wan travel',
                ],
                'medium' => [
                    'The journey wey I travel today take long well well',
                    'I wan travel go where I never been before',
                    'I go fit reach where I wan go',
                    'Travel wey you go with friends dey sweet',
                ],
                'hard' => [
                    'When you dey travel for this road, you go see many things wey go open your eye',
                    'The road wey no get motor na the road wey go teach you things',
                    'Travel wey you go with your family na the best travel',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'One',
                    'Two',
                    'Three',
                    'Four',
                    'Five',
                    'Six',
                    'Seven',
                    'Eight',
                    'Nine',
                    'Ten',
                ],
                'medium' => [
                    'One naira',
                    'Two naira',
                    'Three naira',
                    'Four naira',
                    'Five naira',
                ],
                'hard' => [
                    'One hundred naira',
                    'Two hundred naira',
                    'Three hundred naira',
                    'Four hundred naira',
                    'Five hundred naira',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Thank you',
                    'Sorry',
                    'Yes',
                    'No',
                    'No wahala',
                ],
                'medium' => [
                    'Thank you well well',
                    'I dey find person wey go fit help me',
                    'God go help us',
                    'Make we dey together',
                ],
                'hard' => [
                    'When God dey for your side, nobody fit touch you',
                    'The thing wey you do today go affect tomorrow',
                    'Make we dey careful for this life',
                ],
            ],
            'family' => [
                'easy' => [
                    'My papa',
                    'My mama',
                    'My pikin',
                    'My family',
                    'My friend',
                ],
                'medium' => [
                    'My papa dey work for office',
                    'My mama dey teach for school',
                    'My pikin dey learn well well',
                    'My family dey together well well',
                ],
                'hard' => [
                    'Family wey dey together, nobody fit separate them',
                    'When your papa and mama dey together, e dey make pikin happy',
                    'Friends wey you get for village na the best friends',
                ],
            ],
            'work' => [
                'easy' => [
                    'I dey work',
                    'Work dey well',
                    'I wan work',
                    'Work day',
                ],
                'medium' => [
                    'The work wey I dey do, e dey help me well well',
                    'I wan work with you',
                    'Work dey important well well',
                    'I dey work for morning',
                ],
                'hard' => [
                    'When you dey do work wey you love, e dey feel like say you no dey work at all',
                    'Work wey you dey do for people go affect their life',
                    'Make you dey careful for the work wey you dey do',
                ],
            ],
        ]);
    }

    private function zuluPrompts(): array
    {
        return $this->buildPrompts('zu', [
            'greetings' => [
                'easy' => [
                    'Sawubona',
                    'Unjani',
                    'Ngiyaphila',
                    'Ngubani',
                    'Sala kahle',
                    'Sanibonani',
                    'Hamba kahle',
                    'Yebo',
                ],
                'medium' => [
                    'Unjani namuhla',
                    'Ngiyabonga kakhulu',
                    'Ngiyajabula ukukubona',
                    'Sawubona mngani wami',
                    'Kuhle kakhulu',
                ],
                'hard' => [
                    'Abantu abahlala enhlabathini bathanda ukuzululula',
                    'Umuntu ozwayo ukuthi yena uyazi ukuthi ungakanani',
                    'Lapho abantu behlanganisana, khona lapho khona ukuthula',
                ],
            ],
            'food' => [
                'easy' => [
                    'Dla',
                    'Phuza amanzi',
                    'Dla inyama',
                    'Dla isinkwa',
                    'Ngifuna ukudla',
                    'Amanzi abandayo',
                ],
                'medium' => [
                    'Ukudla okuhlile kunambitheka kakhulu',
                    'Phuza amanzi abandayo kunempilo',
                    'Ngifuna ukudla okuphekwe endlini',
                    'Dla inyama nesinkwa',
                ],
                'hard' => [
                    'Ukudla okuphekwe ngumama kuneambitheka kunokudla okuthengwayo',
                    'Ukudla okudliwa nabangane kunjabulisa kakhulu',
                    'Ukudla okuphekwe ngamathuluzi kunambitheka ngendlela ehlukile',
                ],
            ],
            'travel' => [
                'easy' => [
                    'Ngiyohamba',
                    'Ngifike',
                    'Siyaphambili',
                    'Indlela ilungile',
                    'Ngifuna ukuhamba',
                ],
                'medium' => [
                    'Indlela engihambile yenzeke kakhulu',
                    'Ngifuna ukuhamba endaweni engiyaziyo',
                    'Ukuhamba kunjabulisa',
                    'Indlela inzima',
                ],
                'hard' => [
                    'Ukuhamba endaweni entsha kunifundisa izinto eziningi',
                    'Lapho uhamba nabangane, indlela ifika ngokushesha',
                    'Indlela engiyohambayo iya endaweni engiyithandayo',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'Kunye',
                    'Kubili',
                    'Kuthathu',
                    'Kune',
                    'Kuhlanu',
                    'Kusithupha',
                    'Kusikhombisa',
                    'Kusishiyagalombili',
                    'Kusishiyagalolunye',
                    'Kulishumi',
                ],
                'medium' => [
                    'Iyunithi eyodwa',
                    'Iyunithi emibili',
                    'Iyunithi emithathu',
                    'Iyunithi emine',
                    'Iyunithi emihlanu',
                ],
                'hard' => [
                    'Iyunithi eyikhulu',
                    'Iyunithi emibili',
                    'Iyunithi emithathu',
                    'Iyunithi emine',
                    'Iyunithi emihlanu',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Ngiyabonga',
                    'Kuhle',
                    'Yebo',
                    'Cha',
                    'Kulungile',
                ],
                'medium' => [
                    'Ngiyabonga kakhulu',
                    'Ngiyohlola',
                    'Nkulunkulu akusize',
                    'Masihambe ndawonye',
                ],
                'hard' => [
                    'Lapho Nkulunkulu ekunakekela, akukho muntu onokuthinta',
                    'Izenzo zakho zanamuhla zizothinta kusasa',
                    'Sizobe sijabula uma sihlanganisana',
                ],
            ],
            'family' => [
                'easy' => [
                    'Ubaba wami',
                    'Unina wami',
                    'Ingane yami',
                    'Usaphami lwami',
                    'Umngani wami',
                ],
                'medium' => [
                    'Ubaba wami usebenza ehabhuleli',
                    'Unina wami ufundisa esikoleni',
                    'Ingane yami ifunda kahle',
                    'Usaphami lwami luhlangene kahle',
                ],
                'hard' => [
                    'Usaphami oluhlangene lungabonakala kalula',
                    'Ubaba noNina banika izingane ithuba elihle',
                    'Abangani bakho basezulwini banokukhathalela kakhulu',
                ],
            ],
            'work' => [
                'easy' => [
                    'Ngiyasebenza',
                    'Umsebenzi uhle',
                    'Ngifuna umsebenzi',
                    'Usuku lomsebenzi',
                ],
                'medium' => [
                    'Umsebenzi engiwenza unomncono',
                    'Ngifuna ukusebenza namahhwala',
                    'Umsebenzi ubalulekile',
                    'Ngiyasebenza kusasa',
                ],
                'hard' => [
                    'Umsebenzi owenzo ngokuthanda unjengokungasebenzi nhlobo',
                    'Umsebenzi owenzela abantu uthinta impilo yabo',
                    'Qaphela umsebenzi owenzayo',
                ],
            ],
        ]);
    }

    private function arabicPrompts(): array
    {
        return $this->buildPrompts('ar', [
            'greetings' => [
                'easy' => [
                    'مرحبا',
                    'السلام عليكم',
                    'صباح الخير',
                    'مساء الخير',
                    'كيف حالك',
                    'أهلا وسهلا',
                    'مع السلامة',
                    'شكرا',
                ],
                'medium' => [
                    'كيف حالك اليوم',
                    'أنا سعيد بلقائك',
                    'كيف حال عائلتك',
                    'صباح النور',
                    'مساء الفل',
                ],
                'hard' => [
                    'الذين يعيشون في السعادة يعيشون في نعيم',
                    'الإنسان الذي يعرف نفسه يعرف ربه',
                    'عندما يتجمع الناس يجدون السلام',
                ],
            ],
            'food' => [
                'easy' => [
                    'كُل',
                    'اشرب ماء',
                    'كُل لحما',
                    'كُل خبزا',
                    'أريد أن آكل',
                    'ماء بارد',
                ],
                'medium' => [
                    'الطعام الذي طبخته لذيذ جدا',
                    'اشرب ماء باردا للصحة',
                    'أريد أن آكل طعاما منزليا',
                    'كُل السمك مع الخبز',
                ],
                'hard' => [
                    'الطعام الذي طبخته الأم في المنزل ألذ من أي طعام',
                    'الأكل مع الأصدقاء يسعد القلب',
                    'الطعام المطبوخ بالأعشاب له طعم مختلف',
                ],
            ],
            'travel' => [
                'easy' => [
                    'أذهب',
                    'وصلت',
                    'نقدم',
                    'الطريق جيد',
                    'أريد السفر',
                ],
                'medium' => [
                    'الرحلة التي قمت بها اليوم طويلة جدا',
                    'أريد السفر إلى مكان جديد',
                    'السفر ممتع',
                    'الطريق طويل',
                ],
                'hard' => [
                    'السفر إلى مكان جديد يعلمك أشياء كثيرة',
                    'عندما تسافر مع أصدقائك تصل بسرعة',
                    'الرحلة التي أrigo عيها تكون ممتعة',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'واحد',
                    'اثنان',
                    'ثلاثة',
                    'أربعة',
                    'خمسة',
                    'ستة',
                    'سبعة',
                    'ثمانية',
                    'تسعة',
                    'عشرة',
                ],
                'medium' => [
                    'وحدة واحدة',
                    'وحدة اثنين',
                    'وحدة ثلاثة',
                    'وحدة أربعة',
                    'وحدة خمسة',
                ],
                'hard' => [
                    'مائة وحدة',
                    'مئتا وحدة',
                    'ثلاثمئة وحدة',
                    'أربعمئة وحدة',
                    'خمسمئة وحدة',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'شكرا',
                    'عذرا',
                    'نعم',
                    'لا',
                    'حسنا',
                ],
                'medium' => [
                    'شكرا جزيلا',
                    'سأحاول',
                    'الله ي赐ك البركة',
                    'دعنا نكون معا',
                ],
                'hard' => [
                    'عندما يكون الله معك لا أحد يمكنه لمسك',
                    'أفعالك اليوم ستؤثر على الغد',
                    'كن حذرا في هذه الحياة',
                ],
            ],
            'family' => [
                'easy' => [
                    'أبي',
                    'أمي',
                    'طفلي',
                    'عائلتي',
                    'صديقي',
                ],
                'medium' => [
                    'أبي يعمل في مكتب',
                    'أمي تعلم في مدرسة',
                    'طفلي يدرس جيدا',
                    'عائلتي معا happiest',
                ],
                'hard' => [
                    'العائلة التي تعيش معا لا يمكن فصلها',
                    'الأم والأب يعطيان الطفل فرصة جيدة',
                    'أصدقاؤك في القرية هم أفضل الأصدقاء',
                ],
            ],
            'work' => [
                'easy' => [
                    'أعمل',
                    'العمل جيد',
                    'أريد العمل',
                    'يوم العمل',
                ],
                'medium' => [
                    'العمل الذي أفعله مفيد',
                    'أريد العمل معك',
                    'العمل مهم جدا',
                    'أعمل صباحا',
                ],
                'hard' => [
                    'العمل الذي تفعله بالحب لا يشبه العمل أبدا',
                    'العمل الذي تفعله للناس يؤثر في حياتهم',
                    'كن حذرا في العمل الذي تفعله',
                ],
            ],
        ]);
    }

    private function swahiliPrompts(): array
    {
        return $this->buildPrompts('sw', [
            'greetings' => [
                'easy' => [
                    'Habari',
                    'Hujambo',
                    'Sijambo',
                    'Asante',
                    'Karibu',
                    'Kwaheri',
                    'Habari za asubuhi',
                    'Habari za jioni',
                ],
                'medium' => [
                    'Habari yako leo',
                    'Nashukuru sana',
                    'Nafurahi kukutana nawe',
                    'Habari za familia yako',
                    'U hali gani',
                ],
                'hard' => [
                    'Wanaoishi katika furaha wanaishi katika amani',
                    'Mtu anayejijua anajua Mwenyezi Mungu',
                    'Wanapokutana watu wanapata amani',
                ],
            ],
            'food' => [
                'easy' => [
                    'Kula',
                    'Kunywa maji',
                    'Kula nyama',
                    'Kula mkate',
                    'Nataka kula',
                    'Maji baridi',
                ],
                'medium' => [
                    'Chakula nilichopika ni kitamu sana',
                    'Kunywa maji baridi ni afya',
                    'Nataka kula chakula cha nyumbani',
                    'Kula samaki na mkate',
                ],
                'hard' => [
                    'Chakula ambacho mama amepika ni kitamu kuliko chakula chochote',
                    'Kula na marafiki kunafurahisha sana',
                    'Chakula kilichopikwa kwa mimea una ladha tofauti',
                ],
            ],
            'travel' => [
                'easy' => [
                    'Ninakwenda',
                    'Nimefika',
                    'Tunaendelea',
                    'Njia ni nzuri',
                    'Nataka kusafiri',
                ],
                'medium' => [
                    'Safari niliyofanya leo ilichukua muda mrefu',
                    'Nataka kusafiri mpaka kwenye mahali nipendapo',
                    'Kusafiri ni kufurahisha',
                    'Njia ni ndefu',
                ],
                'hard' => [
                    'Kusafiri kwenye mahali pya kunakufundisha vitu vingi',
                    'Unaposafiri na marafiki, njia inafika haraka',
                    'Safari ambayo nitaipenda itakuwa nzuri',
                ],
            ],
            'numbers' => [
                'easy' => [
                    'Moja',
                    'Mbili',
                    'Tatu',
                    'Nne',
                    'Tano',
                    'Sita',
                    'Saba',
                    'Nane',
                    'Tisa',
                    'Kumi',
                ],
                'medium' => [
                    'Kitengo kimoja',
                    'Kitengo kibili',
                    'Kitengo tatu',
                    'Kitengo nne',
                    'Kitengo tano',
                ],
                'hard' => [
                    'Mia moja',
                    'Mia mbili',
                    'Mia tatu',
                    'Mia nne',
                    'Mia tano',
                ],
            ],
            'common_phrases' => [
                'easy' => [
                    'Asante',
                    'Pole',
                    'Ndiyo',
                    'Hapana',
                    'Sawa',
                ],
                'medium' => [
                    'Asante sana',
                    'Nitajaribu',
                    'Mwenyezi Mungu akubariki',
                    'Tuwe pamoja',
                ],
                'hard' => [
                    'Mwenyezi Mungu anapotembea nawe hakuna mtu anayeweza kukugusa',
                    'Matendo yako ya leo yataathiri kesho',
                    'Kuwa makini katika maisha haya',
                ],
            ],
            'family' => [
                'easy' => [
                    'Baba yangu',
                    'Mama yangu',
                    'Mwanangu',
                    'Familia yangu',
                    'Rafiki yangu',
                ],
                'medium' => [
                    'Baba yangu anafanya kazi ofisini',
                    'Mama yangu anafundisha shuleni',
                    'Mwanangu anasoma vizuri',
                    'Familia yangu iko pamoja vizuri',
                ],
                'hard' => [
                    'Familia inayoungana haiwezi kutenganishwa',
                    'Baba na Mama wanawapa watoto nafasi nzuri',
                    'Marafiki zako katika kijiji ndio marafiki bora',
                ],
            ],
            'work' => [
                'easy' => [
                    'Ninafanya kazi',
                    'Kazi ni nzuri',
                    'Nataka kazi',
                    'Siku ya kazi',
                ],
                'medium' => [
                    'Kazi ninayofanya ni ya manufaa',
                    'Nataka kufanya kazi nawe',
                    'Kazi ni muhimu sana',
                    'Ninafanya kazi asubuhi',
                ],
                'hard' => [
                    'Kazi unayofanya kwa upendo haifanani na kazi',
                    'Kazi unayofanya kwa watu inaathiri maisha yao',
                    'Kuwa makini katika kazi unayofanya',
                ],
            ],
        ]);
    }

    private function buildPrompts(string $language, array $categories): array
    {
        $prompts = [];

        foreach ($categories as $category => $difficulties) {
            foreach ($difficulties as $difficulty => $texts) {
                foreach ($texts as $text) {
                    $prompts[] = [
                        'type' => mb_strlen($text) > 25 ? 'sentence' : 'word',
                        'language' => $language,
                        'category' => $category,
                        'difficulty' => $difficulty,
                        'text' => $text,
                        'is_active' => true,
                    ];
                }
            }
        }

        return $prompts;
    }
}
