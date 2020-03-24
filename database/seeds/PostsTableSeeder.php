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
                'title' => 'Se laver fréquemment les mains',
                'content' => 'Se laver fréquemment les mains avec une solution hydroalcoolique ou à l’eau et au savon<br><b>Pourquoi?</b> Se laver les mains avec une solution hydroalcoolique ou à l’eau et au savon tue le virus s’il est présent sur vos mains.',
                'slug' => 'se-laver-frequemment-les-mains',
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
                'title' => 'Éviter les contacts proches',
                'content' => '<p>
Maintenir une distance d’au moins 1 mètre avec les autres personnes, en particulier si elles toussent, éternuent ou ont de la fièvre.
</p><p><b>Pourquoi?</b> Lorsqu’une personne infectée par un virus respiratoire, comme la COVID-19, tousse ou éternue, elle projette de petites gouttelettes contenant le virus. Si vous êtes trop près, vous pouvez inhaler le virus.
</p>',
                'slug' => 'eviter-les-contacts-proches',
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
                'title' => 'Éviter de se toucher les yeux, le nez et la bouche.',
                'content' => '<b>Pourquoi?</b> Les mains sont en contact avec de nombreuses surfaces qui peuvent être contaminées par le virus. Si vous vous touchez les yeux, le nez ou la bouche, vous risquez d’être en contact avec le virus présent sur ces surfaces.',
                'slug' => 'eviter-de-se-toucher-les-yeux-le-nez-et-la-bouche',
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
                'title' => 'Mesures prises par le Gouvernement 18 mars 2020',
                'content' => '<p>

Suite à son adresse à la nation de ce 18 mars 2020, voici les décisions prises ce mercredi 18 mars 2020 par le Chef de l’État Son Excellence Monsieur Félix-Antoine Tshisekedi Tshilombo, au sujet de l’épidémie au Coronavirus-COVID-19.</p><h3>Mesures Générales<br></h3><ol><li>De suspendre, jusqu’à nouvel ordre, dès ce vendredi 20 mars 2020, tous les vols en provenance des pays à risque et des pays de transit. Seuls les avions et les navires cargos et autres moyens de transport frets seront autorisés à accéder au territoire national et leurs personnels soumis aux contrôles ;</li><li>De reporter les voyages à destination de la République Démocratique du Congo de tous les passagers résidant dans les pays à risque jusqu’à nouvel </li><li>D’imposer à tous les passagers, à leur arrivée aux frontières nationales, de remplir une fiche de renseignements et de se soumettre, sans exception, à l’obligation de lavage des mains et du prélèvement de la température ;</li><li>D’imposer une mise en quarantaine de 14 jours maximum à toute personne suspectée à l’issue du test de température, pour un examen approfondi et au besoin d’interner, dans les hôpitaux prévus à cet effet, les personnes qui seront testées positives ;</li><li>De doter tous les postes d’entrée maritime, fluviale, lacustre et terrestre du territoire national du même dispositif de surveillance pour renforcer le contrôle des passagers en provenance de l’étranger ;</li><li>De soumettre systématiquement les personnes en partance de Kinshasa vers les différentes Provinces de notre pays aux mesures de contrôle dans le but d’éviter la propagation de cette pandémie sur le reste de notre pays.</li></ol><h3> Mesures concernant les rassemblements</h3><p><b>Le Chef de l’État a décidé:</b><br></p><ol><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">D’interdire tous rassemblements, réunions, célébrations, de plus de 20 personnes sur les lieux publics en dehors du domicile familial ;</span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">De la fermeture des écoles, des universités, des instituts supérieurs officiels et privés sur l’ensemble du territoire national à dater de ce jeudi 19 mars 2020 pour une durée de 4 semaines ;</span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">De suspendre tous les cultes pour une période de 4 semaines à compter de ce jeudi 19 mars 2020 ;</span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">De suspendre les activités sportives dans les stades et autres lieux de regroupement sportif jusqu’à nouvel </span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">D’interdire, toujours jusqu’à nouvel ordre, l’ouverture des discothèques, bars, cafés, terrasses et restaurants ;</span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">D’interdire, l’organisation des deuils dans les salles et les domiciles. Les dépouilles mortelles seront conduites directement de la morgue jusqu’au lieu d’inhumation et en nombre restreint d\'accompagnateurs;</span></li><li><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e">De prendre en charge aux frais du Gouvernement tous les cas testés positifs sur l’ensemble du territoire.<br><br></span><b><span style="font-size: 11pt; font-family: Arial; color: rgb(0, 0, 0); background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;" id="docs-internal-guid-953ca373-7fff-554b-2100-cfbd74310b2e"></span></b></li></ol>',
                'slug' => 'mesures-prises-par-le-gouvernement-18-mars-2020',
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
                'title' => 'Le virus de la COVID-19 peut se transmettre sous les climats chauds et humides.',
                'content' => 'D’après les données dont on dispose jusqu’à présent, le virus de la COVID-19 peut se transmettre dans TOUTES LES RÉGIONS, y compris les zones chaudes et humides. Indépendamment du climat, prenez des mesures de protection si vous vivez ou si vous vous rendez dans une zone où il y a des cas de COVID-19. Le meilleur moyen de se protéger contre l’infection est de se laver souvent les mains. Le lavage des mains élimine les virus qui pourraient s’y trouver et évite qu’on ne soit contaminé en se touchant les yeux, le nez ou la bouche.',
                'slug' => 'le-virus-de-la-covid-19-peut-se-transmettre-sous-les-climats-chauds-et-humides',
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
                'title' => 'Prendre un bain chaud ne protège pas contre le nouveau coronavirus.',
                'content' => 'Prendre un bain chaud n’empêche pas de contracter la COVID-19. La température du corps reste normale, entre 36,5°C et 37°C, quelle que soit celle de votre bain ou de votre douche. Par ailleurs, il peut être dangereux de prendre un bain très chaud à cause du risque de brûlure. Le meilleur moyen de se protéger contre la COVID-19 est de se laver souvent les mains. Le lavage des mains élimine les virus qui pourraient s’y trouver et évite qu’on ne soit contaminé en se touchant les yeux, la bouche ou le nez.',
                'slug' => 'prendre-un-bain-chaud-ne-protege-pas-contre-le-nouveau-coronavirus',
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
                'title' => 'Les vaccins contre la pneumonie protègent-ils contre le nouveau coronavirus ?',
                'content' => '<p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;" id="docs-internal-guid-94ace5c5-7fff-72fc-6e1a-d7d15cc5870d">Non. Les vaccins contre la pneumonie tels que le vaccin antipneumococcique et le vaccin anti-Haemophilus influenza type B (Hib) ne confèrent pas de protection contre le nouveau coronavirus.</p>
<p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;">Le virus est si nouveau et différent qu’il nécessite un vaccin qui lui est propre. Les chercheurs travaillent à la mise au point d’un vaccin contre le 2019-nCoV et l’OMS soutient leurs travaux.</p>
<p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;">Bien que ces vaccins ne soient pas efficaces contre le 2019-nCoV, la vaccination contre les maladies respiratoires est fortement recommandée pour protéger votre santé.</p>',
                'slug' => 'les-vaccins-contre-la-pneumonie-protegent-ils-contre-le-nouveau-coronavirus',
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
                'title' => 'Respecter les règles d’hygiène respiratoire',
                'content' => 'Se couvrir la bouche et le nez avec le pli du coude ou avec un mouchoir en cas de toux ou d’éternuement – jeter le mouchoir immédiatement après dans une poubelle fermée et se laver les mains avec une solution hydroalcoolique ou à l’eau et au savon.<br><b>Pourquoi ?</b> Se couvrir la bouche et le nez en cas de toux ou d’éternuement permet d’éviter la propagation des virus et autres agents pathogènes.',
                'slug' => 'respecter-les-regles-d-hygiene-respiratoire',
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
                'title' => 'Tenez-vous informé et suivez les conseils de votre médecin',
                'content' => 'Tenez-vous au courant des dernières évolutions concernant la COVID-19. Suivez les conseils de votre médecin, des autorités de santé nationales et locales ou de votre employeur pour savoir comment vous protéger et protéger les autres de la COVID-19. <br><b>Pourquoi ?</b> Ce sont les autorités nationales et locales qui disposent des informations les plus récentes sur la propagation ou non de la COVID-19 dans la région où vous vous trouvez. Elles sont les mieux placées pour expliquer ce que les personnes dans votre région devraient faire pour se protéger.<br><br>',
                'slug' => 'tenez-vous-informe-et-suivez-les-conseils-de-votre-medecin',
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
                'title' => 'Mesures de protection pour les personnes qui se trouvent ou qui se sont récemment rendues (au cours des 14 derniers jours) dans des régions où la COVID-19 se propage',
                'content' => '<ul><li>

Suivez les conseils présentés ci-dessus.<br></li><li>Si vous commencez à vous sentir mal, même si vous n’avez que des symptômes bénins comme des maux de tête et un faible écoulement nasal, restez chez vous jusqu’à la guérison. Pourquoi ? Éviter d’entrer en contact avec d’autres personnes et de se rendre dans des établissements de santé permettra à ces établissements de fonctionner plus efficacement et vous protègera, ainsi que les autres personnes, de la COVID-19 et d’autres maladies virales. </li><li>En cas de fièvre, de toux et de difficultés respiratoires, consultez un médecin sans tarder, car il peut s’agir d’une infection respiratoire ou d’une autre affection grave. Appelez votre médecin et indiquez-lui si vous avez récemment voyagé ou été en contact avec des voyageurs. Pourquoi ? Si vous l’appelez, votre médecin pourra vous orienter rapidement vers l’établissement de santé le plus adapté. En outre, cela vous protègera et évitera la propagation de la COVID-19 et d’autres maladies virales</li></ul>',
                'slug' => 'mesures-de-protection-pour-les-personnes-qui-se-trouvent-ou-qui-se-sont-recemment-rendues-au-cours-des-14-derniers-jours-dans-des-regions-ou-la-covid-19-se-propage',
                'category_id' => 1,
                'created_at' => '2020-03-20 19:47:02',
                'updated_at' => '2020-03-20 19:47:02',
                'image_path' => NULL,
                'width' => 12,
                'order' => 6,
            ),
//             10 =>
//             array(
//                 'id' => 11,
//                 'title' => 'Quand utiliser un masque ?',
//                 'content' => '<ul><li>

// Si vous êtes en bonne santé, vous ne devez utiliser un masque que si vous vous occupez d’une personne présumée infectée par le 2019‑nCoV.</li><li>Portez un masque si vous toussez ou éternuez.</li><li>Le masque n’est efficace que s’il est associé à un lavage des mains fréquent avec une solution hydroalcoolique ou à l’eau et au savon. </li><li>Si vous portez un masque, il est important que vous sachiez l’utiliser et l’éliminer correctement.<br><br></li></ul>',
//                 'slug' => 'quand-utiliser-un-masque',
//                 'category_id' => 1,
//                 'created_at' => '2020-03-20 19:47:45',
//                 'updated_at' => '2020-03-20 19:47:45',
//                 'image_path' => NULL,
//                 'width' => 4,
//                 'order' => 0,
//             ),
//             11 =>
//             array(
//                 'id' => 12,
//                 'title' => 'Comment mettre, utiliser, enlever et éliminer un masque',
//                 'content' => '<ul><li>

// Avant de mettre un masque, se laver les mains avec une solution hydroalcoolique ou à l’eau et au savon</li><li>Appliquer le masque de façon à recouvrir le nez et la bouche et veillez à l’ajuster au mieux sur votre visage</li><li>Lorsque l’on porte un masque, éviter de le toucher; chaque fois que l’on touche un masque usagé, se laver les mains à l’aide d’une solution hydroalcoolique ou à l’eau et au savon </li><li>Lorsqu’il s’humidifie, le remplacer par un nouveau masque et ne pas réutiliser des masques à usage unique</li><li>Pour retirer le masque: l’enlever par derrière (ne pas toucher le devant du masque); le jeter immédiatement dans une poubelle fermée; se laver les mains avec une solution hydroalcoolique ou à l’eau et au savon<br><br></li></ul>',
//                 'slug' => 'comment-mettre-utiliser-enlever-et-eliminer-un-masque',
//                 'category_id' => 1,
//                 'created_at' => '2020-03-20 19:51:45',
//                 'updated_at' => '2020-03-20 19:51:45',
//                 'image_path' => NULL,
//                 'width' => 4,
//                 'order' => 0,
//             ),
            12 =>
            array(
                'id' => 13,
                'title' => 'Les sèche-mains sont-ils efficaces pour tuer le nCoV 2019 ?',
                'content' => 'Non. Les sèche-mains ne sont pas efficaces pour tuer le 2019-nCoV. Pour vous protéger contre le nouveau coronavirus, vous devez vous nettoyer fréquemment les mains avec un produit hydroalcoolique ou à l’eau et au savon. Une fois que vos mains sont propres, vous devez les sécher soigneusement à l’aide de serviettes en papier ou d’un séchoir à air chaud. <br>',
                'slug' => 'les-seche-mains-sont-ils-efficaces-pour-tuer-le-ncov-2019',
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
                'title' => 'Puis-je réutiliser un masque N95 ? Puis-je le laver ? Puis-je le stériliser avec des désinfectants pour les mains ?',
                'content' => 'Non. Les masques faciaux, y compris les masques médicaux plats ou les masques N95, ne doivent pas être réutilisés. Si vous avez été en contact étroit avec une personne infectée par le nouveau coronavirus ou qui présente une autre infection respiratoire, le devant de votre masque doit être considéré comme contaminé. Vous devez enlever le masque sans toucher sa partie avant et le jeter de manière appropriée. Après avoir enlevé votre masque, vous devez vous nettoyer les mains avec un produit hydroalcoolique ou à l’eau et au savon.',
                'slug' => 'puis-je-reutiliser-un-masque-n95-puis-je-le-laver-puis-je-le-steriliser-avec-des-desinfectants-pour-les-mains',
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
                'title' => 'Une lampe de désinfection à ultraviolets (UV) peut-elle tuer le nouveau coronavirus (nCoV) ?',
                'content' => '<p>

Les lampes à UV ne doivent pas être utilisées pour se stériliser les mains ou d’autres parties du corps, car les rayons UV peuvent provoquer des érythèmes (irritation de la peau).<br>Pour vous protéger contre le nouveau coronavirus, tenez-vous au courant de toutes les mesures que vous pouvez adopter. Pour plus de détails, voir le site Web de l’OMS : </p><p><a href="https://www.who.int/fr/emergencies/diseases/novel-coronavirus-2019/advice-for-public" target="_blank">https://www.who.int/fr/emergencies/diseases/novel-coronavirus-2019/advice-for-public</a><br></p>',
                'slug' => 'une-lampe-de-desinfection-a-ultraviolets-uv-peut-elle-tuer-le-nouveau-coronavirus-ncov',
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
