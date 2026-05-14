<img src="web/assets/img/CitizenRoom (black).svg">

## Why CitizenRoom?

In 1945, the **Citizens' Band** was created in the United States. CB was one of the various radio services regulated by the Federal Communications Commission (FCC), allowing citizens to use a radio frequency band for **personal communication** (for example radio-controlled models, conversations between relatives and friends, and small businesses) [>> Wikipedia source](https://it.wikipedia.org/wiki/Banda_cittadina).
<br><br>

CitizenRoom was created with the idea of reusing the same model and proposing the use of a part of the web in a way that is free from any relationship with a public or private intermediary (whether paid or free in exchange for personal information), by developing an audio communication service dedicated to personal communication among citizens.
<br><br>

CitizenRoom is a platform for creating rooms in which it is possible to organize **audio-only** meetings with a theoretically unlimited number of participants: the prototype currently available to you allows inviting up to **10 people** per room, for an indicative total of 100 users simultaneously connected to the platform in order to ensure proper operation.
<br><br>

CitizenRoom is **free, open source and does not require either the creation of an account** or the installation of applications (desktop or mobile): you can create rooms freely and without limits and, by using a button that generates an invitation link, you can allow anyone to join without forcing them to create an account or install software on their device.

We felt the need to create and test a platform that would focus more on **simplicity** than on service customization.
<br><br>

**Audio conferencing for a sustainable future**<br>
CitizenRoom stands out for its flexibility, offering the possibility of holding audio-only conferences. This feature was designed to meet several needs, including optimizing bandwidth and ensuring more inclusive access to communication. A particularly important and symbolic reason behind this choice is **energy saving**. At a time when environmental sustainability is crucial, choosing to communicate through audio only significantly reduces the energy consumption associated with the transmission and management of video streams. This not only helps reduce ecological impact, but also makes CitizenRoom a conscious choice for those who wish to combine effective communication with environmental responsibility.
<br><br>

## Data management

CitizenRoom does not store **any user data, device data or conversation data**. This does not mean that CitizenRoom is an application in which one can enjoy total anonymity; on the contrary: CitizenRoom is a **free but unencrypted** platform, therefore at any time, in the event of improper and/or illegal exchange of information, **any conversation may be monitored by a competent authority**.
CitizenRoom aims to be a simple and immediate means of communication, but not a tool for concealing one's identity for unlawful purposes contrary to the laws of the State in which the platform is located and from which users connect.
<br><br>

## Self-hosted Jitsi Meet

CitizenRoom uses an infrastructure separated between the public interface and the audio conferencing service, in order to make the platform easier to manage, more transparent and more reliable.
<br><br>

The **front-end**, that is, the part visible to and directly used by users to create, configure and access rooms, is developed in **PHP/Javascript** and is published on an **Altervista** server.
The **back-end**, that is, the service that actually manages the audio rooms, is based on the official documentation and implementation of [Jitsi Meet](https://jitsi.github.io/handbook/) and is hosted on a **dedicated privately owned server**.
<br><br>

This separation offers an important advantage even for non-technical users: on the one hand, the public interface can remain lightweight, accessible and easy to update; on the other, the audio conferencing engine runs on a machine dedicated exclusively to this task, allowing greater control over performance, service continuity and infrastructure management.
<br><br>

The dedicated server on which the back-end runs has about **8 GB of RAM** and a **4-core ARM CPU**, a configuration designed to efficiently support the current prototype and the use of audio rooms within the limits indicated by the platform. The use of a dedicated server also makes it possible to avoid complete dependence on centralized external services and to experiment with a more autonomous, controllable form of infrastructure consistent with the spirit of the project.
<br><br>

From the point of view of security and technical reliability, the server uses a modern architecture and is not directly exposed to many of the main known hardware vulnerabilities that have affected other systems in recent years. This also helps provide a more solid foundation for the service.
<br><br>

*   The TLS certificate was issued by [Let's Encrypt](https://letsencrypt.org/), on behalf of the cultural association InMediArt.
*   DNS is managed through [NO-IP](https://www.noip.com/) via the account of the association ResponsabItaly.
<br><br>

<hr>

## Room Types

### Public rooms

Public rooms represent the freest and most immediate form of access to CitizenRoom. To enter, there is no need to create an account, provide personal data or install applications: it is enough to choose a **room number** and a **nickname**. In this way, anyone can quickly open an audio conversation space and invite other participants simply by sharing an **access link**. It is the most essential form of CitizenRoom: an open, lightweight, ready-to-use room designed to encourage direct communication between people.
<br><br>

### Custom rooms

Custom rooms were created to offer a meeting space that can be recognized, presented and shared even outside the platform. In these rooms it is possible to define a **title**, associate a **logo** and add a **link to a personal, associative or institutional website**. In this way, the room is not only a place to access the conversation, but can become an integral part of the communication of an event, an association or a project, through an invitation link that can be freely published and shared on one's own web channels.
<br><br>

### Topic rooms

Topic rooms are CitizenRoom spaces that build their interface using open data available on the web, through live calls to public APIs or CSV files downloaded from websites that make them available.
<br><br>

#### Parliament rooms

Parliament rooms are themed rooms dedicated to members of parliament: each room is built around public data concerning a representative.
CitizenRoom provides parliamentary rooms for 3 parliaments:
*   **European Parliament**, data source: [data.europarl.europa.eu](https://data.europarl.europa.eu/fr/datasets/deputes-au-parlement-europeen-legislature10/58)
*   **Italian Parliament (Chamber of Deputies)**, data source: [dati.camera.it](https://dati.camera.it/)
*   **French Parliament (Assemblée Nationale)**, data source: [data.assemblee-nationale.fr](https://data.assemblee-nationale.fr/acteurs/deputes-en-exercice)
<br>

#### Municipality rooms

Municipality rooms are themed rooms dedicated to municipalities: each room is built around public data concerning a municipality.
CitizenRoom provides municipal rooms for 2 countries:
*   **Italian municipalities**, data source: [Comuni ITA API](https://github.com/Samurai016/Comuni-ITA), [dait.interno.gov.it - Local administrators](https://dait.interno.gov.it/elezioni/open-data/amministratori-locali-e-regionali-in-carica)
*   **French municipalities**, data source: [geo.api.gouv.fr](https://geo.api.gouv.fr/), [data.gouv.fr - National register of elected officials](https://www.data.gouv.fr/datasets/repertoire-national-des-elus-1/)
<br>
<hr>
<br>

## Collaborative whiteboard

Each room gives access to a collaborative whiteboard shared with all users in the room.
This feature is made possible thanks to the Open Source project [WBO](https://wbo.ophir.dev/) by developer [Ophir LOJKINE](https://ophir.dev/).
<br><br>
<br>
<hr>
<br>

## An Open Source prototype

CitizenRoom is a prototype web conferencing platform based on the public API of [Jitsi Meet](https://meet.jit.si/), written in PHP/Javascript and completely Open Source.
The prototype code can be read and, if desired, proposals for modification can be made on GitHub in the dedicated [repository](https://github.com/gvincenzi/citizenroom).
<br><br>
<br>
<hr>
<br>

## Project funding

CitizenRoom was also created as an experiment in digital autonomy: to show that a communication tool can be simple, public in spirit, open in its code, and not based on the collection of personal data, even outside the logic of large commercial platforms.
<br><br>

The platform is financially supported by the cultural associations **[ResponsabItaly](https://www.responsabitaly.org)**, **[InMediArt](https://www.inmediart.ovh)** and **[AssoEtica](https://www.assoetica.it)**, which share its cultural vision and its goal of building communication tools that are freer, more sober and more accessible.
<br><br>

For the years **2025** and **2026**, the total costs incurred for CitizenRoom amounted to **300 euros VAT included**.
<br><br>

This deliberately limited amount expresses a principle even before it defines a technical model: it is possible to build and maintain an essential communication infrastructure with limited resources, without relying on advertising, user profiling or dependence on proprietary ecosystems. In this sense, CitizenRoom is not only a technological prototype, but also a small political and cultural proposal: to give citizens back a direct, lightweight and governable space for communication.
