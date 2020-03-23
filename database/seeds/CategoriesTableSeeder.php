<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Mesures de protection essentielles contre le nouveau coronavirus',
                'icon' => NULL,
                'slug' => NULL,
                'description'=>'
                <h2 style="margin: 0px 0px 0.5rem; padding: 0px; font-family: Rubik, sans-serif; line-height: 1.2; color: rgb(33, 37, 41); font-size: 2rem;">Qu’est-ce qu’un coronavirus ?</h2>
    <p style="margin-bottom: 1rem; padding: 0px; font-family: Rubik, sans-serif; color: rgb(33, 37, 41); font-size: 16px;">Les coronavirus forment une vaste famille de virus qui peuvent être pathogènes chez l’homme et chez l’animal. On sait que, chez l’être humain, plusieurs coronavirus peuvent entraîner des infections respiratoires dont les manifestations vont du simple rhume à des maladies plus graves comme le syndrome respiratoire du Moyen-Orient (MERS) et le syndrome respiratoire aigu sévère (SRAS). Le dernier coronavirus qui a été découvert est responsable de la maladie à coronavirus 2019 (COVID-19).</p>
    <h2 style="margin: 0px 0px 0.5rem; padding: 0px; font-family: Rubik, sans-serif; line-height: 1.2; color: rgb(33, 37, 41); font-size: 2rem;">Quels sont les symptômes de la COVID-19 ?</h2>
    <p style="margin-bottom: 1rem; padding: 0px; font-family: Rubik, sans-serif; color: rgb(33, 37, 41); font-size: 16px;">Les symptômes les plus courants de la COVID-19 sont la fièvre, la fatigue et une toux sèche. Certains patients présentent des douleurs, une congestion nasale, un écoulement nasal, des maux de gorge ou une diarrhée. Ces symptômes sont généralement bénins et apparaissent de manière progressive. Certaines personnes, bien qu’infectées, ne présentent aucun symptôme et se sentent bien.&nbsp;<span style="margin: 0px; padding: 0px; font-weight: bolder;">La plupart (environ 80 %) des personnes guérissent sans avoir besoin de traitement particulier.</span>&nbsp;Environ une personne sur six contractant la maladie présente des symptômes plus graves, notamment une dyspnée. Les personnes âgées et celles qui ont d’autres problèmes de santé (hypertension artérielle, problèmes cardiaques ou diabète) ont plus de risques de présenter des symptômes graves. Toute personne qui a de la fièvre, qui tousse et qui a des&nbsp;<span style="margin: 0px; padding: 0px; font-weight: bolder;">difficultés à respirer doit consulter un médecin.</span></p>
    <h2 style="margin: 0px 0px 0.5rem; padding: 0px; font-family: Rubik, sans-serif; line-height: 1.2; color: rgb(33, 37, 41); font-size: 2rem;">Comment la COVID-19 se propage-t-elle ?</h2>
    <p style="margin-bottom: 1rem; padding: 0px; font-family: Rubik, sans-serif; color: rgb(33, 37, 41); font-size: 16px;">La COVID-19 est transmise par des personnes porteuses du virus. La maladie peut se transmettre d’une personne à l’autre par le biais de gouttelettes respiratoires expulsées par le nez ou par la bouche lorsqu’une personne&nbsp;<span style="margin: 0px; padding: 0px; font-weight: bolder;">tousse ou éternue</span>. Ces gouttelettes peuvent se retrouver sur des objets ou des surfaces autour de la personne en question. On peut alors contracter la COVID-19 si on&nbsp;<span style="margin: 0px; padding: 0px; font-weight: bolder;">touche ces objets ou ces surfaces</span>&nbsp;et si on se touche ensuite les yeux, le nez ou la bouche. Il est également possible de contracter la COVID-19 en inhalant des gouttelettes d’une personne malade qui vient de tousser ou d’éternuer. C’est pourquoi il est important de se tenir à plus d’un mètre d’une personne malade.</p>
            ',
                'created_at' => '2020-03-20 15:55:33',
                'updated_at' => '2020-03-20 15:55:33',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mesures prises par le Gouvernement',
                'icon' => NULL,
                'slug' => 'mesures-prises-par-le-gouvernement',
                'description' => 'A',
                'created_at' => '2020-03-20 16:07:44',
                'updated_at' => '2020-03-20 16:07:44',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'En finir avec les idées reçues',
                'icon' => NULL,
                'slug' => 'en-finir-avec-les-idees-recues',
                'description' => 'A',
                'created_at' => '2020-03-20 16:07:58',
                'updated_at' => '2020-03-20 16:07:58',
            ),
        ));
        
        
    }
}