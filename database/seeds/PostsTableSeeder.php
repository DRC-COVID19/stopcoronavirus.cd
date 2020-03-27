<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->delete();

        DB::table('posts')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:57:31',
                'updated_at' => '2020-03-20 20:42:23',
                'image_path' => null,
                'width' => 4,
                'order' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:58:59',
                'updated_at' => '2020-03-20 20:42:48',
                'image_path' => null,
                'width' => 4,
                'order' => 2,
            ),
            2 =>
            array(
                'id' => 3,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:59:26',
                'updated_at' => '2020-03-20 20:43:06',
                'image_path' => null,
                'width' => 4,
                'order' => 3,
            ),
            3 =>
            array(
                'id' => 4,
                'category_id' => 2,
                'created_at' => '2020-03-20 18:45:26',
                'updated_at' => '2020-03-23 16:25:19',
                'image_path' => NULL,
                'width' => 4,
                'order' => 1,
            ),
            4 =>
            array(
                'id' => 5,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:53:44',
                'updated_at' => '2020-03-20 19:00:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            5 =>
            array(
                'id' => 6,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:54:33',
                'updated_at' => '2020-03-20 18:54:33',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            6 =>
            array(
                'id' => 7,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:55:09',
                'updated_at' => '2020-03-20 19:00:48',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            7 =>
            array(
                'id' => 8,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:45:27',
                'updated_at' => '2020-03-20 19:45:27',
                'image_path' => NULL,
                'width' => 4,
                'order' => 4,
            ),
            8 =>
            array(
                'id' => 9,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:46:00',
                'updated_at' => '2020-03-20 19:46:00',
                'image_path' => NULL,
                'width' => 4,
                'order' => 5,
            ),
            9 =>
            array(
                'id' => 10,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:47:02',
                'updated_at' => '2020-03-20 19:47:02',
                'image_path' => NULL,
                'width' => 12,
                'order' => 6,
            ),
            12 =>
            array(
                'id' => 13,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:05:15',
                'updated_at' => '2020-03-20 20:05:15',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            13 =>
            array(
                'id' => 14,
                 'category_id' => 3,
                'created_at' => '2020-03-20 20:05:48',
                'updated_at' => '2020-03-20 20:05:48',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            14 =>
            array(
                'id' => 15,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:06:33',
                'updated_at' => '2020-03-20 20:06:33',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            15 =>
            array(
                'id' => 16,
                'title' => 'La pulvérisation d’alcool ou de chlore sur tout le corps peut-elle tuer le nouveau coronavirus (nCoV) ?',
                'content' => '<p>

<p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;" id="docs-internal-guid-dce4dcae-7fff-5b04-7be8-3a2360ba784a"><span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Non. Vaporiser de l’alcool ou du chlore sur tout le corps ne tuera pas les virus qui ont déjà pénétré dans votre corps. La pulvérisation de ces substances peut être nocive pour les vêtements ou les muqueuses (c’est-à-dire les yeux, la bouche). Sachez que l’alcool et le chlore peuvent tous deux être utiles pour désinfecter les surfaces, mais ils doivent être utilisés en suivant les recommandations appropriées.&nbsp;</span></p><span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Il existe plusieurs mesures que vous pouvez adopter pour vous protéger contre le nouveau coronavirus. Commencez par vous nettoyer fréquemment les mains en utilisant un produit hydroalcoolique – comme un gel – ou à l’eau et au savon. Pour connaître les autres mesures de protection, consultez les conseils de l’OMS à l’adresse</span><a href="https://www.who.int/fr/emergencies/diseases/novel-coronavirus-2019/advice-for-public" style="text-decoration:none;"><span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"> </span></a></p><p><a href="https://www.who.int/fr/emergencies/diseases/novel-coronavirus-2019/advice-for-public" target="_blank">https://www.who.int/fr/emergencies/diseases/novel-coronavirus-2019/advice-for-public</a><br></p>',
                'slug' => 'la-pulverisation-d-alcool-ou-de-chlore-sur-tout-le-corps-peut-elle-tuer-le-nouveau-coronavirus-ncov',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:07:35',
                'updated_at' => '2020-03-20 20:07:35',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            16 =>
            array(
                'id' => 17,
                'title' => 'Est-il sans danger de recevoir une lettre ou un colis de Chine ?',
                'content' => '<span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;" id="docs-internal-guid-cf19b1aa-7fff-3141-4c79-55886ee6c5e2">Oui, c’est sans danger. Les personnes qui reçoivent des colis en provenance de Chine ne risquent pas de contracter le nouveau coronavirus. D’après des analyses antérieures, nous savons que les coronavirus ne survivent pas longtemps sur des objets, tels que des lettres ou des colis.</span>',
                'slug' => 'est-il-sans-danger-de-recevoir-une-lettre-ou-un-colis-de-chine',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:08:04',
                'updated_at' => '2020-03-20 20:08:04',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            17 =>
            array(
                'id' => 18,
                'title' => 'Les vaccins contre la pneumonie protègent-ils contre le nouveau coronavirus ?',
                'content' => '<p>

Non. Les vaccins contre la pneumonie, tels que le vaccin antipneumococcique et le vaccin contre Haemophilus influenza type B (Hib), n’offrent pas de protection contre le nouveau coronavirus.<br>Le virus est tellement nouveau et différent qu’il nécessite un vaccin qui lui est propre. Les chercheurs sont en train de travailler à la mise au point d’un vaccin contre le 2019-nCoV et l’OMS les soutient dans leurs travaux.<br>Bien que ces vaccins ne soient pas efficaces contre le 2019-nCoV, la vaccination contre les maladies respiratoires est fortement recommandée pour protéger votre santé.<br><br></p>',
                'slug' => 'les-vaccins-contre-la-pneumonie-protegent-ils-contre-le-nouveau-coronavirus-1',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:08:36',
                'updated_at' => '2020-03-20 20:08:36',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            18 =>
            array(
                'id' => 19,
                'title' => 'Se rincer régulièrement le nez avec une solution saline peut-il aider à prévenir l\'infection par le nouveau coronavirus ?',
                'content' => '<p>

Non. Rien ne prouve que le fait de se rincer régulièrement le nez avec une solution saline protège les gens contre l’infection par le nouveau coronavirus. <br>Il existe quelques éléments probants indiquant que cette pratique peut aider les gens à se remettre plus rapidement d’un rhume ordinaire. Cependant, il n’a pas été démontré que le fait de se rincer régulièrement le nez permettait de prévenir les infections respiratoires<br><br></p>',
                'slug' => 'se-rincer-regulierement-le-nez-avec-une-solution-saline-peut-il-aider-a-prevenir-l-infection-par-le-nouveau-coronavirus',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:09:05',
                'updated_at' => '2020-03-20 20:09:05',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            19 =>
            array(
                'id' => 20,
                'title' => 'Manger de l\'ail peut-il aider à prévenir l\'infection par le nouveau coronavirus ?',
                'content' => '<span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;" id="docs-internal-guid-20f47878-7fff-87d6-789d-114ac7e588bd">L’ail est un aliment sain qui peut avoir certaines propriétés antimicrobiennes. Cependant, rien ne prouve, dans le cadre de l’épidémie actuelle, que la consommation d’ail protège les gens contre le nouveau coronavirus.</span>',
                'slug' => 'manger-de-l-ail-peut-il-aider-a-prevenir-l-infection-par-le-nouveau-coronavirus',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:09:37',
                'updated_at' => '2020-03-20 20:09:37',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            20 =>
            array(
                'id' => 21,
                'title' => 'Le fait de mettre de l\'huile de sésame empêche-t-il le nouveau coronavirus de pénétrer dans l\'organisme ?',
                'content' => '<p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;" id="docs-internal-guid-9db37927-7fff-0460-fbea-c42bd0950aa2"><span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Non. L’huile de sésame ne tue pas le nouveau coronavirus. Il existe des désinfectants chimiques qui peuvent tuer le 2019-nCoV sur les surfaces. Il s’agit notamment de désinfectants à base d’eau de Javel ou de chlore, de solvants, d’éthanol à 75%, d’acide peracétique et de chloroforme.&nbsp;</span></p><p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;"><span style="font-size:11pt;font-family:Arial;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Cependant, ils ont peu d’impact sinon aucun sur le virus si vous les mettez sur la peau ou sous votre nez. Il peut même être dangereux de se mettre ces produits chimiques sur la peau..</span></p>',
                'slug' => 'le-fait-de-mettre-de-l-huile-de-sesame-empeche-t-il-le-nouveau-coronavirus-de-penetrer-dans-l-organisme',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:10:04',
                'updated_at' => '2020-03-20 20:10:04',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            21 =>
            array(
                'id' => 22,
                'title' => 'Le nouveau coronavirus affecte-t-il les personnes âgées ou les jeunes y sont-ils également sensibles ?',
                'content' => 'Les personnes de tous âges peuvent être infectées par le nouveau coronavirus (2019-nCoV). Les personnes âgées et les personnes souffrant de maladies préexistantes (comme l’asthme, le diabète, les maladies cardiaques) semblent plus susceptibles de tomber gravement malades à cause de ce virus. &nbsp;<br>L’OMS conseille aux personnes de tous âges de prendre des mesures pour se protéger du virus, par exemple en suivant une bonne hygiène des mains et une bonne hygiène respiratoire.<br><br>',
                'slug' => 'le-nouveau-coronavirus-affecte-t-il-les-personnes-agees-ou-les-jeunes-y-sont-ils-egalement-sensibles',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:10:30',
                'updated_at' => '2020-03-20 20:10:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            22 =>
            array(
                'id' => 23,
                'title' => 'Les antibiotiques sont-ils efficaces pour prévenir et traiter l\'infection par le nouveau coronavirus ?',
                'content' => '<p>

Non, les antibiotiques n’agissent pas contre les virus, mais seulement contre les bactéries.<br>Le nouveau coronavirus (2019-nCoV) est un virus et, par conséquent, les antibiotiques ne doivent pas être utilisés comme moyen de prévention ou de traitement.<br>Cependant, si vous êtes hospitalisé pour une infection par le 2019-nCoV, vous pouvez recevoir des antibiotiques car une co-infection bactérienne est possible.<br></p>',
                'slug' => 'les-antibiotiques-sont-ils-efficaces-pour-prevenir-et-traiter-l-infection-par-le-nouveau-coronavirus',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:11:01',
                'updated_at' => '2020-03-20 20:11:01',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            23 =>
            array(
                'id' => 24,
                'title' => 'Existe-t-il des médicaments spécifiques pour prévenir ou traiter l\'infection par le nouveau coronavirus ?',
                'content' => 'À ce jour, aucun médicament spécifique n’est recommandé pour prévenir ou traiter l’infection par le nouveau coronavirus (2019-nCoV).<br>Toutefois, les personnes infectées par le virus doivent recevoir des soins appropriés pour soulager et traiter les symptômes, et celles qui sont gravement malades doivent recevoir des soins de soutien optimisés. Certains traitements spécifiques sont à l’étude et seront testés dans le cadre d’essais cliniques. L’OMS contribue à accélérer les efforts de recherche et de développement avec toute une série de partenaires.<br>',
                'slug' => 'existe-t-il-des-medicaments-specifiques-pour-prevenir-ou-traiter-l-infection-par-le-nouveau-coronavirus',
                'category_id' => 3,
                'created_at' => '2020-03-20 20:11:30',
                'updated_at' => '2020-03-20 20:11:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
        ));
    }
}
