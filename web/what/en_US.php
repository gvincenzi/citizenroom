<?php
$cookieDisclaimer = ("
<h2>What is CitizenRoom and why?</h2>
In 1945, the <strong>Citizens' Band</strong> was created in the United States.<br>
CB was one of the various radio services regulated by the Federal Communications Commission (FCC), allowing citizens to use a radio frequency band for <strong>personal communication</strong> (for example radio-controlled models, conversations between relatives and friends, and small businesses) <strong><a href='https://it.wikipedia.org/wiki/Banda_cittadina'> >> Wikipedia source</a></strong>.
<br><br>

CitizenRoom was created with the idea of reusing the same model and proposing the use of a part of the web in a way that is free from any relationship with a public or private intermediary (whether paid or free in exchange for personal information), by developing a conferencing service dedicated to personal communication among citizens.<br><br>

CitizenRoom is a platform for creating rooms in which it is possible to organize meetings with a theoretically unlimited number of participants: the prototype currently available to you allows inviting up to <strong>10 people</strong> per room, for an indicative total of 100 users simultaneously connected to the platform in order to ensure proper operation.<br><br>

CitizenRoom is <strong>free, open source and does not require either the creation of an account</strong> or the installation of applications (desktop or mobile): you can create rooms freely and without limits and, by using a button that generates an invitation link, you can allow anyone to join without forcing them to create an account or install software on their device.

We felt the need to create and test a platform that would focus more on <strong>simplicity</strong> than on service customization.<br><br>

<strong>Audio conferences for a sustainable future</strong><br>
In CitizenRoom, <strong>audio-only mode is the default setting</strong>. This choice reflects the intention to promote communication that is lighter, more accessible, and more sustainable. Audio helps optimize bandwidth, supports participation even with limited internet connections, and makes meetings more inclusive. One particularly important and symbolic reason behind this default setting is <strong>energy saving</strong>: limiting video use significantly reduces the energy consumption associated with transmitting and managing audiovisual streams, thereby helping to lower environmental impact. <strong>Video can still be activated at any time</strong>, but CitizenRoom displays an on-screen message inviting users to reflect on its environmental impact and on whether activating it is truly necessary. In this way, the platform encourages a conscious choice that combines effective communication with environmental responsibility.<br><br>

<h2>Data management</h2>
CitizenRoom does not store <strong>any user data, device data or conversation data</strong>. This does not mean that CitizenRoom is an application in which one can enjoy total anonymity; on the contrary: CitizenRoom is a <strong>free but unencrypted</strong> platform, therefore at any time, in the event of improper and/or illegal exchange of information, <strong>any conversation may be monitored by a competent authority</strong>.<br>
CitizenRoom aims to be a simple and immediate means of communication, but not a tool for concealing one's identity for unlawful purposes contrary to the laws of the State in which the platform is located and from which users connect.<br><br>

<h2>Self-hosted Jitsi Meet</h2>
CitizenRoom uses an infrastructure separated between the public interface and the conferencing service, in order to make the platform easier to manage, more transparent and more reliable.<br><br>

The <strong>front-end</strong>, that is, the part visible to and directly used by users to create, configure and access rooms, is developed in <strong>PHP/Javascript</strong> and is published on an <strong>Altervista</strong> server.<br>
The <strong>back-end</strong>, that is, the service that actually manages the rooms, is based on the official documentation and implementation of <a href='https://jitsi.github.io/handbook/'>Jitsi Meet</a> and is hosted on a <strong>dedicated privately owned server</strong>.<br><br>

This separation offers an important advantage even for non-technical users: on the one hand, the public interface can remain lightweight, accessible and easy to update; on the other, the conferencing engine runs on a machine dedicated exclusively to this task, allowing greater control over performance, service continuity and infrastructure management.<br><br>

The dedicated server on which the back-end runs has about <strong>8 GB of RAM</strong> and a <strong>4-core ARM CPU</strong>, a configuration designed to efficiently support the current prototype and the use of rooms within the limits indicated by the platform. The use of a dedicated server also makes it possible to avoid complete dependence on centralized external services and to experiment with a more autonomous, controllable form of infrastructure consistent with the spirit of the project.<br><br>

From the point of view of security and technical reliability, the server uses a modern architecture and is not directly exposed to many of the main known hardware vulnerabilities that have affected other systems in recent years. This also helps provide a more solid foundation for the service.<br><br>

<ul>
<li>The TLS certificate was issued by <a href='https://letsencrypt.org/'>Let's Encrypt</a>, on behalf of the cultural association InMediArt.
<li>DNS is managed through <a href='https://www.noip.com/'>NO-IP</a> via the account of the association ResponsabItaly.
</ul><br>

<hr>
<h2>Public rooms</h2>
Public rooms represent the freest and most immediate form of access to CitizenRoom. To enter, there is no need to create an account, provide personal data or install applications: it is enough to choose a <strong>room number</strong> and a <strong>nickname</strong>. In this way, anyone can quickly open a conversation space and invite other participants simply by sharing an <strong>access link</strong>. It is the most essential form of CitizenRoom: an open, lightweight, ready-to-use room designed to encourage direct communication between people.<br><br>
<br>
<h2>Custom rooms</h2>
Custom rooms were created to offer a meeting space that can be recognized, presented and shared even outside the platform. In these rooms it is possible to define a <strong>title</strong>, associate a <strong>logo</strong> and add a <strong>link to a personal, associative or institutional website</strong>. In this way, the room is not only a place to access the conversation, but can become an integral part of the communication of an event, an association or a project, through an invitation link that can be freely published and shared on one's own web channels.<br><br>

<br>
<h2>Topic rooms</h2>
Topic rooms are CitizenRoom spaces that build their interface using open data available on the web, through live calls to public APIs or CSV files downloaded from websites that make them available.<br><br>

<h3>Parliament rooms</h3>
Parliament rooms are themed rooms dedicated to members of parliament: each room is built around public data concerning a representative.<br/>
CitizenRoom provides parliamentary rooms for 3 parliaments:
<ul>
<li><b>European Parliament</b>, data source: <a href='https://data.europarl.europa.eu/fr/datasets/deputes-au-parlement-europeen-legislature10/58'>data.europarl.europa.eu</a></li>
<li><b>Italian Parliament (Chamber of Deputies)</b>, data source: <a href='https://dati.camera.it/'>dati.camera.it</a></li>
<li><b>French Parliament (Assemblée Nationale)</b>, data source: <a href='https://data.assemblee-nationale.fr/acteurs/deputes-en-exercice'>data.assemblee-nationale.fr</a></li>
</ul>
<br>

<h3>Municipality rooms</h3>
Municipality rooms are themed rooms dedicated to municipalities: each room is built around public data concerning a municipality.<br/>
CitizenRoom provides municipal rooms for 2 countries:
<ul>
<li><b>Italian municipalities</b>, data source: <a href='https://github.com/Samurai016/Comuni-ITA'>Comuni ITA API</a>, <a href='https://dait.interno.gov.it/elezioni/open-data/amministratori-locali-e-regionali-in-carica'>dait.interno.gov.it - Local administrators</a></li>
<li><b>French municipalities</b>, data source: <a href='https://geo.api.gouv.fr/'>geo.api.gouv.fr</a>, <a href='https://www.data.gouv.fr/datasets/repertoire-national-des-elus-1/'>data.gouv.fr - National register of elected officials</a></li>
</ul>
<br>
<hr>
<br>
<h2>Collaborative whiteboard</h2>
Each room gives access to a collaborative whiteboard shared with all users in the room.
This feature is made possible thanks to the Open Source project <a href='https://wbo.ophir.dev/'>WBO</a> by developer <a href='https://ophir.dev/'>Ophir LOJKINE</a>.<br><br>
<br>
<hr>
<br>
<h2>An Open Source prototype</h2>
CitizenRoom is a prototype web conferencing platform based on the public API of <a href='https://meet.jit.si/'>Jitsi Meet</a>, written in PHP/Javascript and completely Open Source.<br>
The prototype code can be read and, if desired, proposals for modification can be made on GitHub in the dedicated <a href='https://github.com/gvincenzi/citizenroom'>repository</a>.<br><br>
<br>
<hr>
<br>

<h2>Project funding</h2>
CitizenRoom was also created as an experiment in digital autonomy: to show that a communication tool can be simple, public in spirit, open in its code, and not based on the collection of personal data, even outside the logic of large commercial platforms.<br><br>

The platform is financially supported by the cultural associations <strong><a href='https://www.responsabitaly.org'>ResponsabItaly</a></strong>, <strong><a href='https://www.inmediart.ovh'>InMediArt</a></strong> and <strong><a href='https://www.assoetica.it'>AssoEtica</a></strong>, which share its cultural vision and its goal of building communication tools that are freer, more sober and more accessible.<br><br>

For the years <strong>2025</strong> and <strong>2026</strong>, the total costs incurred for CitizenRoom amounted to <strong>300 euros VAT included</strong>.<br><br>

This deliberately limited amount expresses a principle even before it defines a technical model: it is possible to build and maintain an essential communication infrastructure with limited resources, without relying on advertising, user profiling or dependence on proprietary ecosystems. In this sense, CitizenRoom is not only a technological prototype, but also a small political and cultural proposal: to give citizens back a direct, lightweight and governable space for communication.<br><br>

");
?>
