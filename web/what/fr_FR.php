<?php 
$cookieDisclaimer = ("
<h2>POURQUOI CITIZENROOM?</h2>
La <strong>Citizens’Band</strong> voit le jour en 1945, aux États-Unis. Communément connue sous l’acronyme CB, cela était l’un des services de radio réglementés par la
Federal Communications Commission (FCC) pour permettre aux citoyens d’utiliser une bande de fréquences radio pour la communication personnelle (par exemple, les appareils radiocommandés, les conversations entre membres de la famille et entre amis, les petites entreprises)<strong><a href='https://fr.wikipedia.org/wiki/Citizen-band'> >> source Wikipedia</a></strong>.
<br><br>


Citizenroom naît d’une idée de vouloir révolutionner la façon dont nous utilisons une partie du web aujourd’hui, en proposant un service open-source, libre de tout engagement avec un intermédiaire public ou privé, appliquant le même modèle que la CB. Cela signifie que, contrairement à ce qui se passe aujourd’hui sur le Web (que vous utilisiez des interfaces payantes ou gratuites), aucune de vos informations personnelles n’est stockée ou volée. Nous avons juste voulu créer un service de communication audio et vidéo dédié aux interactions personnelles entre les citoyens.<br><br>

Citizenroom est une plateforme où vous pouvez créer des salles virtuelles dans lesquelles vous avez la possibilité d’organiser des réunions (audio et vidéo) avec un nombre théorique illimité de participants : toutefois, il est fortement recommandé de limiter l’utilisation du prototype actuellement disponible à un maximum de <strong>20 personnes</strong> simultanément pour qu’il fonctionne correctement.<br><br>

Citizenroom est entièrement <strong>gratuit, open source et vous pouvez l’utiliser sans devoir créer un compte personnel ou télécharger d’applications</strong> (que ce soit sur votre PC ou téléphone mobile) : vous pouvez facilement créer un nombre illimité de salles et, juste en un clic, générer un lien d’invitation prêt à être partagé avec les personnes de votre choix et que vous voulez inviter dans la salle. De l’autre côté, les personnes que vous invitez à rejoindre la salle, auront accès à celle-ci en cliquant simplement sur votre lien pour y accéder et ils ne seront pas obligés de créer un compte ou d’installer un logiciel sur leur appareil.<br>
Nous avons fortement senti le besoin de créer et de tester une plate-forme axée sur la <strong>simplicité</strong> plutôt que sur la personnalisation du service.<br><br>

<h2>GESTION DES DONNÉES</h2>
Citizenroom <strong>ne stocke aucune donnée liée aux utilisateurs, aux appareils ni aux échanges de communication</strong>. Cela ne signifie pas que Citizenroom soit une plateforme qui garantit un complet anonymat et, malgré le fait que la plateforme soit gratuite, elle est complètement <strong>décryptée</strong>. À tout moment, en cas d’échange d’informations incorrectes et/ou illégales, <strong>toutes conversations peuvent être monitorées par les autorités compétentes</strong>. Citizenroom vise à être un outil de communication simple et immédiat, mais pas un moyen pour dissimuler votre identité à des fins illicites ou contre la loi du pays où la plateforme est située ou d’où les gens sont connectés.<br><br>

<h2>Self hosted Jitsi Meet</h2>
Citizenroom utilise un serveur Jitsi Meet auto-hébergé <a href='https://citizenroom.ddns.net'>ici</a> :<br>
<ul>
<li>Le certificat TLS a été délivré par <a href='https://letsencrypt.org/'>Let's Encrypt</a>, signé par l'association InMediArt.
<li>Le DNS a été géré via <a href='https://www.noip.com/'>NO-IP</a> avec le compte de l'association ResponsabItaly.
</ul><br><br>

<h2>Tableau blanc collaboratif</h2>
Chaque salle donne accès à un tableau blanc collaboratif, partagé avec tous les utilisateurs de la salle.
Cette fonctionnalité est rendue possible grâce au projet Open Source<a href='https://wbo.ophir.dev/'>WBO</a> du développeur <a href='https://ophir.dev/'>Ophir LOJKINE</a>.<br><br>
<br>
<hr>
<br>
<h2>Salle thématique</h2>
Les chambres à thème sont des CitizenRooms qui construisent l'interface grâce aux données ouvertes disponibles sur le réseau (via des appels en direct à des API publiques ou avec des fichiers CSV téléchargés depuis des sites qui les publient).<br><br>

<h3>Salles Parlementaires</h3>
Les salles parlementaires sont des salles à thème dédiées aux parlementaires : chaque salle se construit autour des données publiques d'un député.<br/>
CitizenRoom propose des salles parlementaires pour 3 parlements :
<ul>
<li><b>Parlement Européen</b>, source des données : <a href='https://data.europarl.europa.eu/fr/datasets/deputes-au-parlement-europeen-legislature10/58'>data.europarl.europa.eu</a></li>
<li><b>Parlement Italien (Camera dei deputati)</b>, source des données : <a href='https://dati.camera.it/'>dati.camera.it</a></li>
<li><b>Parlement Français (Assemblée Nationale)</b>, source des données : <a href='https://data.assemblee-nationale.fr/acteurs/deputes-en-exercice'>data.assemblee-nationale.fr</a></li>
</ul>
<br>

<h3>Salles municipales</h3>
Les salles municipales sont des salles à thème dédiées aux municipalités : chaque salle est construite autour des données publiques d'une commune.<br/>
CitizenRoom propose des salles municipales pour 2 pays :
<ul>
<li><b>Communes italiennes</b>, source des données : <a href='https://github.com/Samurai016/Comuni-ITA'>Comuni ITA API</a></li>
<li><b>Communes françaises</b>, source des données : <a href='https://geo.api.gouv.fr/'>geo.api.gouv.fr</a></li>
</ul>
<br>
<hr>
<br>
<h2>UN PROTOTYPE OPEN SOURCE</h2>
Citizenroom est un prototype de plateforme de conférence web, basé sur l'api public <a href='https://meet.jit.si/'>Jitsi Meet</a>, écrit en PHP/Javascript et complètement open source. Vous pouvez lire le code du prototype et, si vous le souhaitez, proposer de le modifier sur Github dans le <a href='https://github.com/gvincenzi/citizenroom'>repository dédié</a>.
<br><br>

");
?>
