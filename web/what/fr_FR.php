<?php
$cookieDisclaimer = ("
<h2>Qu'est-ce que CitizenRoom et pourquoi ?</h2>
En 1945, aux États-Unis, naquit la <strong>Citizens' Band</strong>, la bande citoyenne.<br>
La CB était l'un des différents services radio réglementés par la Federal Communications Commission (FCC), permettant aux citoyens d'utiliser une bande de fréquences radio pour la <strong>communication personnelle</strong> (par exemple les modèles radiocommandés, les conversations entre parents et amis, les petites entreprises) <strong><a href='https://it.wikipedia.org/wiki/Banda_cittadina'> >> source Wikipédia</a></strong>.
<br><br>

CitizenRoom est né de l'idée de réutiliser le même schéma et de proposer l'usage d'une partie du web de manière libre, sans relation avec un intermédiaire public ou privé (payant ou gratuit en échange d'informations personnelles), en développant un service de communication audio destiné à la communication personnelle entre citoyens.<br><br>

CitizenRoom est une plateforme de création de salles dans lesquelles il est possible d'organiser des réunions <strong>uniquement audio</strong> avec un nombre théoriquement illimité de participants : le prototype actuellement à votre disposition permet d'inviter jusqu'à <strong>10 personnes</strong> par salle, pour un total indicatif de 100 utilisateurs connectés simultanément à la plateforme afin d'en garantir le bon fonctionnement.<br><br>

CitizenRoom est <strong>gratuit, open source et ne nécessite ni la création d'un compte</strong>, ni l'installation d'applications (desktop ou mobile) : vous pouvez créer des salles librement et sans limite et, à l'aide d'un bouton générant un lien d'invitation, vous pouvez permettre à n'importe qui de participer sans l'obliger à créer un compte ou à installer un logiciel sur son appareil.

Nous avons ressenti le besoin de créer et de tester une plateforme qui mise davantage sur la <strong>simplicité</strong> que sur la personnalisation du service.<br><br>

<strong>Des audioconférences pour un avenir durable</strong><br>
CitizenRoom se distingue par sa flexibilité, en offrant la possibilité d'organiser des conférences exclusivement audio. Cette fonctionnalité a été pensée pour répondre à plusieurs besoins, notamment l'optimisation de la bande passante et la garantie d'un accès plus inclusif à la communication. Une raison particulièrement importante et symbolique derrière ce choix est <strong>l'économie d'énergie</strong>. À une époque où la durabilité environnementale est cruciale, choisir de communiquer uniquement par l'audio réduit significativement la consommation d'énergie liée à la transmission et à la gestion des flux vidéo. Cela contribue non seulement à réduire l'impact écologique, mais fait aussi de CitizenRoom un choix conscient pour celles et ceux qui souhaitent associer efficacité de communication et responsabilité environnementale.<br><br>

<h2>Gestion des données</h2>
CitizenRoom n'enregistre <strong>aucune donnée des utilisateurs, des appareils ou des conversations</strong>. Cela ne signifie pas que CitizenRoom soit une application permettant de bénéficier d'un anonymat total ; au contraire : CitizenRoom est une plateforme <strong>libre mais non chiffrée</strong>, donc à tout moment, en cas d'échange d'informations inapproprié et/ou illégal, <strong>toute conversation pourra être surveillée par une autorité compétente</strong>.<br>
CitizenRoom veut être un moyen simple et immédiat, mais non un outil de dissimulation de son identité à des fins illicites et contraires à la loi de l'État dans lequel la plateforme est située et depuis lequel les utilisateurs se connectent.<br><br>

<h2>Jitsi Meet auto-hébergé</h2>
CitizenRoom utilise une infrastructure séparée entre l'interface publique et le service d'audioconférence, afin de rendre la plateforme plus simple à gérer, plus transparente et plus fiable.<br><br>

Le <strong>front-end</strong>, c'est-à-dire la partie visible et utilisée directement par les utilisateurs pour créer, configurer et rejoindre les salles, est développé en <strong>PHP/Javascript</strong> et publié sur un serveur <strong>Altervista</strong>.<br>
Le <strong>back-end</strong>, c'est-à-dire le service qui gère concrètement les salles audio, est quant à lui fondé sur la documentation et l'implémentation officielles de <a href='https://jitsi.github.io/handbook/'>Jitsi Meet</a> et hébergé sur un <strong>serveur propriétaire et dédié</strong>.<br><br>

Cette séparation présente un avantage important même pour les personnes non techniques : d'un côté, l'interface publique peut rester légère, accessible et facilement mise à jour ; de l'autre, le moteur des audioconférences fonctionne sur une machine dédiée exclusivement à cette tâche, avec un plus grand contrôle sur les performances, la continuité du service et la gestion de l'infrastructure.<br><br>

Le serveur dédié sur lequel fonctionne le back-end dispose d'environ <strong>8 Go de mémoire RAM</strong> et d'un <strong>processeur ARM à 4 cœurs</strong>, une configuration pensée pour soutenir efficacement le prototype actuel et l'usage des salles audio dans les limites indiquées par la plateforme. L'utilisation d'un serveur dédié permet également d'éviter une dépendance totale à des services externes centralisés et d'expérimenter une forme d'infrastructure plus autonome, maîtrisable et cohérente avec l'esprit du projet.<br><br>

Du point de vue de la sécurité et de la fiabilité technique, le serveur utilise une architecture moderne et n'est pas directement exposé à un grand nombre des principales vulnérabilités matérielles connues qui ont affecté d'autres systèmes ces dernières années. Cela contribue également à offrir une base plus solide pour le fonctionnement du service.<br><br>

<ul>
<li>Le certificat TLS a été délivré par <a href='https://letsencrypt.org/'>Let's Encrypt</a>, au nom de l'association culturelle InMediArt.
<li>Le DNS est géré via <a href='https://www.noip.com/'>NO-IP</a> à travers le compte de l'association ResponsabItaly.
</ul><br>

<hr>
<h2>Salles publiques</h2>
Les salles publiques représentent la forme la plus libre et la plus immédiate d'accès à CitizenRoom. Pour y entrer, il n'est pas nécessaire de créer un compte, de fournir des données personnelles ou d'installer des applications : il suffit de choisir un <strong>numéro de salle</strong> et un <strong>pseudonyme</strong>. De cette manière, chacun peut rapidement ouvrir un espace de conversation audio et inviter d'autres participants simplement en partageant un <strong>lien d'accès</strong>. C'est la forme la plus essentielle de CitizenRoom : une salle ouverte, légère, prête à l'emploi, pensée pour favoriser la communication directe entre les personnes.<br><br>
<br>
<h2>Salles personnalisées</h2>
Les salles personnalisées ont été conçues pour offrir un espace de rencontre pouvant être identifié, présenté et partagé également en dehors de la plateforme. Dans ces salles, il est possible de définir un <strong>titre</strong>, d'associer un <strong>logo</strong> et d'insérer un <strong>lien vers un site web</strong> personnel, associatif ou institutionnel. Ainsi, la salle n'est pas seulement un lieu d'accès à la conversation, mais peut devenir une partie intégrante de la communication d'un événement, d'une association ou d'un projet, grâce à un lien d'invitation pouvant être librement publié et diffusé sur ses propres canaux web.<br><br>

<br>
<h2>Salles thématiques</h2>
Les salles thématiques sont des espaces CitizenRoom qui construisent leur interface grâce à des open data disponibles sur le web, par des appels en direct à des API publiques ou à partir de fichiers CSV téléchargés depuis des sites qui les mettent à disposition.<br><br>

<h3>Salles parlementaires</h3>
Les salles parlementaires sont des salles thématiques dédiées aux parlementaires : chaque salle se construit autour de données publiques concernant un député.<br/>
CitizenRoom propose des salles parlementaires pour 3 parlements :
<ul>
<li><b>Parlement européen</b>, source des données : <a href='https://data.europarl.europa.eu/fr/datasets/deputes-au-parlement-europeen-legislature10/58'>data.europarl.europa.eu</a></li>
<li><b>Parlement italien (Chambre des députés)</b>, source des données : <a href='https://dati.camera.it/'>dati.camera.it</a></li>
<li><b>Parlement français (Assemblée nationale)</b>, source des données : <a href='https://data.assemblee-nationale.fr/acteurs/deputes-en-exercice'>data.assemblee-nationale.fr</a></li>
</ul>
<br>

<h3>Salles municipales</h3>
Les salles municipales sont des salles thématiques dédiées aux municipalités : chaque salle se construit autour de données publiques concernant une commune.<br/>
CitizenRoom propose des salles municipales pour 2 pays :
<ul>
<li><b>Communes italiennes</b>, source des données : <a href='https://github.com/Samurai016/Comuni-ITA'>Comuni ITA API</a>, <a href='https://dait.interno.gov.it/elezioni/open-data/amministratori-locali-e-regionali-in-carica'>dait.interno.gov.it - Administrateurs locaux</a></li>
<li><b>Communes françaises</b>, source des données : <a href='https://geo.api.gouv.fr/'>geo.api.gouv.fr</a>, <a href='https://www.data.gouv.fr/datasets/repertoire-national-des-elus-1/'>data.gouv.fr - Répertoire national des élus</a></li>
</ul>
<br>
<hr>
<br>
<h2>Tableau blanc collaboratif</h2>
Chaque salle donne accès à un tableau blanc collaboratif, partagé avec tous les utilisateurs de la salle.
Cette fonctionnalité est rendue possible grâce au projet Open Source <a href='https://wbo.ophir.dev/'>WBO</a> du développeur <a href='https://ophir.dev/'>Ophir LOJKINE</a>.<br><br>
<br>
<hr>
<br>
<h2>Un prototype Open Source</h2>
CitizenRoom est un prototype de plateforme de conférences web, fondé sur l'API publique de <a href='https://meet.jit.si/'>Jitsi Meet</a>, écrit en PHP/Javascript et entièrement Open Source.<br>
Le code du prototype peut être consulté et, le cas échéant, faire l'objet de propositions de modification sur GitHub dans le <a href='https://github.com/gvincenzi/citizenroom'>dépôt dédié</a>.<br><br>
<br>
<hr>
<br>

<h2>Financement du projet</h2>
CitizenRoom est aussi né comme une expérience d'autonomie numérique : montrer qu'un outil de communication peut être simple, public dans son esprit, ouvert dans son code et non fondé sur la collecte de données personnelles, en dehors de la logique des grandes plateformes commerciales.<br><br>

La plateforme est financée par les associations culturelles <strong><a href='https://www.responsabitaly.org'>ResponsabItaly</a></strong>, <strong><a href='https://www.inmediart.ovh'>InMediArt</a></strong> et <strong><a href='https://www.assoetica.it'>AssoEtica</a></strong>, qui partagent son orientation culturelle et son objectif de construire des outils de communication plus libres, plus sobres et plus accessibles.<br><br>

Pour les années <strong>2025</strong> et <strong>2026</strong>, les coûts totaux engagés pour CitizenRoom se sont élevés à <strong>300 euros TTC</strong>.<br><br>

Il s'agit d'un montant volontairement limité, qui affirme un principe avant même de définir un modèle technique : il est possible de concevoir et de maintenir une infrastructure essentielle de communication collective avec des ressources limitées, sans recourir à la publicité, au profilage des utilisateurs ni à la dépendance envers des écosystèmes propriétaires. En ce sens, CitizenRoom n'est pas seulement un prototype technologique, mais aussi une petite proposition politique et culturelle : redonner aux citoyens un espace de communication direct, léger et gouvernable.<br><br>

");
?>
