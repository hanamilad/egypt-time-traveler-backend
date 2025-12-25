<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Visa;
use App\Models\BestTime;
use App\Models\Season;
use App\Models\Packing;
use App\Models\PackingCategory;
use App\Models\Etiquette;
use App\Models\EtiquetteTip;
use App\Models\SiteInfo;

class ContentSeeder extends Seeder
{
    public function run()
    {
        // Visa
        $visa = Visa::create([
            'title_en' => 'Visa Requirements',
            'title_de' => 'Visumanforderungen',
            'intro_en' => "Most visitors need a visa to enter Egypt. Here's what you need to know:",
            'intro_de' => "Die meisten Besucher benötigen ein Visum für die Einreise nach Ägypten. Hier ist, was Sie wissen müssen:",
            'items_en' => [
                "Tourist visas are available on arrival for citizens of most countries",
                "Visa on arrival costs approximately $25 USD",
                "E-visa available through the official Egyptian e-visa portal",
                "Passport must be valid for at least 6 months from entry date",
                "EU, US, UK, Australian citizens eligible for visa on arrival",
                "Some nationalities require pre-arranged visa from Egyptian embassy"
            ],
            'items_de' => [
                "Touristenvisa sind bei der Ankunft für Bürger der meisten Länder erhältlich",
                "Visum bei Ankunft kostet ca. 25 USD",
                "E-Visum über das offizielle ägyptische E-Visum-Portal erhältlich",
                "Reisepass muss ab Einreisedatum noch mindestens 6 Monate gültig sein",
                "EU-, US-, UK-, australische Bürger sind für Visum bei Ankunft berechtigt",
                "Einige Nationalitäten benötigen ein vorab organisiertes Visum von der ägyptischen Botschaft"
            ]
        ]);

        // Best Time
        $bestTime = BestTime::create([
            'title_en' => 'Best Time to Visit',
            'title_de' => 'Beste Reisezeit',
            'intro_en' => 'Egypt can be visited year-round, but some seasons are more comfortable:',
            'intro_de' => 'Ägypten kann das ganze Jahr über besucht werden, aber einige Jahreszeiten sind angenehmer:',
        ]);

        $seasons = [
            'winter' => [
                'name_en' => 'Winter (Nov–Feb)',
                'name_de' => 'Winter (Nov–Feb)',
                'description_en' => 'Best time to visit. Mild temperatures (15–25°C), perfect for sightseeing.',
                'description_de' => 'Beste Reisezeit. Milde Temperaturen (15–25°C), perfekt für Besichtigungen.'
            ],
            'spring' => [
                'name_en' => 'Spring (Mar–Apr)',
                'name_de' => 'Frühling (Mär–Apr)',
                'description_en' => 'Pleasant weather, occasional sandstorms. Good for Nile cruises.',
                'description_de' => 'Angenehmes Wetter, gelegentliche Sandstürme. Gut für Nilkreuzfahrten.'
            ],
            'summer' => [
                'name_en' => 'Summer (May–Sep)',
                'name_de' => 'Sommer (Mai–Sep)',
                'description_en' => 'Very hot (35–45°C). Best for Red Sea beach resorts.',
                'description_de' => 'Sehr heiß (35–45°C). Am besten für Badeorte am Roten Meer.'
            ],
            'fall' => [
                'name_en' => 'Fall (Oct)',
                'name_de' => 'Herbst (Okt)',
                'description_en' => 'Temperatures cooling down. Great time for all activities.',
                'description_de' => 'Temperaturen kühlen ab. Tolle Zeit für alle Aktivitäten.'
            ]
        ];

        foreach ($seasons as $key => $data) {
            Season::create([
                'best_time_id' => $bestTime->id,
                'season_name' => $key,
                'name_en' => $data['name_en'],
                'name_de' => $data['name_de'],
                'description_en' => $data['description_en'],
                'description_de' => $data['description_de'],
            ]);
        }

        // Packing
        $packing = Packing::create([
            'title_en' => 'Packing List',
            'title_de' => 'Packliste',
            'intro_en' => 'Essential items for your Egypt trip:',
            'intro_de' => 'Wichtige Gegenstände für Ihre Ägypten-Reise:',
        ]);

        $categories = [
            'clothing' => [
                'name_en' => 'Clothing',
                'name_de' => 'Kleidung',
                'items_en' => [
                    "Lightweight, breathable fabrics (cotton, linen)",
                    "Modest clothing for temple visits (covering shoulders/knees)",
                    "Comfortable walking shoes",
                    "Sun hat and sunglasses",
                    "Light jacket for air-conditioned places and cool evenings"
                ],
                'items_de' => [
                    "Leichte, atmungsaktive Stoffe (Baumwolle, Leinen)",
                    "Bescheidene Kleidung für Tempelbesuche (Schultern/Knie bedecken)",
                    "Bequeme Wanderschuhe",
                    "Sonnenhut und Sonnenbrille",
                    "Leichte Jacke für klimatisierte Orte und kühle Abende"
                ]
            ],
            'essentials' => [
                'name_en' => 'Essentials',
                'name_de' => 'Wichtiges',
                'items_en' => [
                    "Sunscreen (SPF 50+)",
                    "Insect repellent",
                    "Reusable water bottle",
                    "Power adapter (Type C or F)",
                    "Prescription medications in original packaging"
                ],
                'items_de' => [
                    "Sonnencreme (LSF 50+)",
                    "Insektenschutzmittel",
                    "Wiederverwendbare Wasserflasche",
                    "Stromadapter (Typ C oder F)",
                    "Verschreibungspflichtige Medikamente in Originalverpackung"
                ]
            ],
            'documents' => [
                'name_en' => 'Documents',
                'name_de' => 'Dokumente',
                'items_en' => [
                    "Passport with 6+ months validity",
                    "Printed hotel confirmations",
                    "Travel insurance documents",
                    "Copies of important documents"
                ],
                'items_de' => [
                    "Reisepass mit 6+ Monaten Gültigkeit",
                    "Gedruckte Hotelbestätigungen",
                    "Reiseversicherungsdokumente",
                    "Kopien wichtiger Dokumente"
                ]
            ]
        ];

        foreach ($categories as $data) {
            PackingCategory::create([
                'packing_id' => $packing->id,
                'name_en' => $data['name_en'],
                'name_de' => $data['name_de'],
                'items_en' => $data['items_en'],
                'items_de' => $data['items_de'],
            ]);
        }

        // Etiquette
        $etiquette = Etiquette::create([
            'title_en' => 'Cultural Etiquette',
            'title_de' => 'Kulturelle Etikette',
            'intro_en' => 'Respect local customs to enhance your experience:',
            'intro_de' => 'Respektieren Sie lokale Bräuche, um Ihr Erlebnis zu verbessern:',
        ]);

        $tips = [
            [
                "title_en" => "Dress Modestly",
                "title_de" => "Bescheiden kleiden",
                "description_en" => "Cover shoulders and knees when visiting religious sites. Women may want to carry a scarf.",
                "description_de" => "Bedecken Sie Schultern und Knie beim Besuch religiöser Stätten. Frauen sollten ein Tuch mitnehmen."
            ],
            [
                "title_en" => "Photography",
                "title_de" => "Fotografieren",
                "description_en" => "Always ask permission before photographing people. Some sites have photography restrictions.",
                "description_de" => "Fragen Sie immer um Erlaubnis, bevor Sie Menschen fotografieren. Einige Stätten haben Fotografiebeschränkungen."
            ],
            [
                "title_en" => "Greetings",
                "title_de" => "Begrüßungen",
                "description_en" => "A handshake is common. Some conservative Muslims may prefer not to shake hands with opposite gender.",
                "description_de" => "Händeschütteln ist üblich. Manche konservative Muslime bevorzugen es, dem anderen Geschlecht nicht die Hand zu geben."
            ],
            [
                "title_en" => "Bargaining",
                "title_de" => "Handeln",
                "description_en" => "Expected in markets (souks). Start at 50% of asking price and negotiate politely.",
                "description_de" => "Auf Märkten (Souks) erwartet. Beginnen Sie bei 50% des Preises und verhandeln Sie höflich."
            ],
            [
                "title_en" => "Tipping (Baksheesh)",
                "title_de" => "Trinkgeld (Bakschisch)",
                "description_en" => "Tipping is customary. Keep small bills handy for guides, drivers, and service staff.",
                "description_de" => "Trinkgeld ist üblich. Halten Sie kleine Scheine für Reiseführer, Fahrer und Servicepersonal bereit."
            ],
            [
                "title_en" => "Ramadan",
                "title_de" => "Ramadan",
                "description_en" => "During Ramadan, avoid eating, drinking, or smoking in public during daylight hours.",
                "description_de" => "Während des Ramadan vermeiden Sie es, tagsüber in der Öffentlichkeit zu essen, zu trinken oder zu rauchen."
            ]
        ];

        foreach ($tips as $tip) {
            EtiquetteTip::create([
                'etiquette_id' => $etiquette->id,
                'title_en' => $tip['title_en'],
                'title_de' => $tip['title_de'],
                'description_en' => $tip['description_en'],
                'description_de' => $tip['description_de'],
            ]);
        }

        // Site Info
        SiteInfo::create([
            'brand1' => 'Time',
            'brand2' => 'Traveller',
            'tagline' => 'Your gateway to ancient wonders. Expert-guided tours through 5000 years of Egyptian history.',
            'social_links' => [
                'facebook' => '#',
                'instagram' => '#',
                'youtube' => '#',
                'twitter' => '#',
            ],
            'address' => '123 Nile Street, Cairo, Egypt',
            'phone' => '+20 123 456 7890',
            'email' => 'info@egypttours.com',
            'availability' => '24/7 Available',
        ]);
    }
}
