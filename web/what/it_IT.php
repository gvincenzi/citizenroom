<?php
$cookieDisclaimer = ("
<h2>Che cos'è e perché CitizenRoom?</h2>
Nel 1945 negli Stati Uniti nacque la <strong>Citizens' Band, la banda cittadina</strong>.<br>
CB era uno dei vari servizi radio regolamentati dalla Federal Communications Commission (FCC) per consentire ai cittadini di utilizzare una banda di frequenze radio per la <strong>comunicazione personale</strong> (ad esempio i modellini radiocomandati, le chiacchiere fra parenti ed amici, le piccole imprese) <strong><a href='https://it.wikipedia.org/wiki/Banda_cittadina'> >> fonte Wikipedia</a></strong>.
<br><br>

CitizenRoom nasce con l'idea di riutilizzare lo stesso schema e proporre l'utilizzo di una parte del web in modo libero da qualsiasi rapporto con un intermediario pubblico o privato (a pagamento o gratuito ma in cambio di informazioni personali), sviluppando un servizio di comunicazione audio da dedicare alla comunicazione personale tra i cittadini.<br><br>

CitizenRoom è una piattaforma per la creazione di stanze in cui poter poter organizzare delle riunioni (<strong>solo audio</strong>) con un numero teoricamente illimitato di partecipanti: il prototipo che è attualmente a vostra disposizione permette di invitare fino a <strong>10 persone</strong> per stanza, per un totale indicativo di 100 utenti contemporaneamente collegati sulla piattaforma per un corretto funzionamento.<br><br>

CitizenRoom è <strong>gratuito, open source e non necessita né della creazione di un conto</strong>, né dell'installazione di applicaziioni (desktop o mobile): potete creare delle stanze liberamente e senza limiti e, utilizzando un tasto che vi genera un link di invito, potrete far partecipare chiunque senza obbligarlo a crearsi un conto o installare un software sul suo dispositivo.

Abbiamo sentito l'esigenza di creare e testare una piattaforma che puntasse piuttosto sulla <strong>semplicità</strong> che sulla personalizzazione del servizio.<br><br>

<strong>Audioconferenze per un futuro sostenibile</strong><br>
CitizenRoom si distingue per la sua flessibilità, offrendo la possibilità di condurre conferenze esclusivamente audio. Questa funzionalità è stata pensata per rispondere a diverse esigenze, tra cui quelle di ottimizzare la larghezza di banda e garantire un accesso più inclusivo alle comunicazioni. Un motivo particolarmente importante e simbolico dietro questa scelta è il <strong>risparmio energetico</strong>. In un'epoca in cui la sostenibilità ambientale è cruciale, scegliere di comunicare solo tramite audio riduce significativamente il consumo di energia associato alla trasmissione e alla gestione dei flussi video. Questo non solo contribuisce a un minore impatto ecologico, ma rende anche CitizenRoom una scelta consapevole per chi desidera unire efficacia comunicativa e responsabilità ambientale.<br><br>

<h2>Gestione dei dati</h2>
CitizenRoom non salva <strong>nessun dato degli utenti, dei dispositivi, della conversazione</strong>. Questo non significa che CitizenRoom sia un'applicazione in cui poter godere di un totale anonimato, al contrario: CitizenRoom è una piattaforma <strong>libera ma non cifrata</strong>, quindi in ogni momento, in caso di scambio di informazioni scorretto e/o illegale, <strong>ogni conversazione potrà essere monitorata da un'autorità competente</strong>.<br>
CitizenRoom vuole essere un mezzo semplice e immediato, ma non uno strumento di offuscamento della propria identità per fini illeciti e contrari alla legge dello Stato in cui la piattaforma è situata e da cui gli utenti si connettono.<br><br>

<h2>Self hosted Jitsi Meet</h2>
CitizenRoom utilizza un'infrastruttura separata tra interfaccia pubblica e servizio di audioconferenza, in modo da rendere la piattaforma più semplice da gestire, più trasparente e più affidabile.<br><br>

Il <strong>front-end</strong>, cioè la parte visibile e utilizzata direttamente dagli utenti per creare, configurare e raggiungere le stanze, è sviluppato in <strong>PHP/Javascript</strong> ed è pubblicato su un server <strong>Altervista</strong>.<br>
Il <strong>back-end</strong>, cioè il servizio che gestisce concretamente le stanze audio, è invece basato sulla documentazione e sull'implementazione ufficiale di <a href='https://jitsi.github.io/handbook/'>Jitsi Meet</a> ed è ospitato su un <strong>server proprietario e dedicato</strong>.<br><br>

Questa separazione presenta un vantaggio importante anche per chi non ha competenze tecniche: da una parte l'interfaccia pubblica può restare leggera, accessibile e facilmente aggiornabile; dall'altra il motore delle audioconferenze funziona su una macchina dedicata esclusivamente a questo compito, con maggior controllo sulle prestazioni, sulla continuità del servizio e sulla gestione dell'infrastruttura.<br><br>

Il server dedicato su cui gira il back-end dispone di circa <strong>8 GB di memoria RAM</strong> e di una <strong>CPU ARM a 4 core</strong>, una configurazione pensata per sostenere in modo efficiente il prototipo attuale e l'utilizzo delle stanze audio nei limiti indicati dalla piattaforma. L'uso di un server dedicato consente inoltre di evitare la dipendenza completa da servizi esterni centralizzati e di sperimentare una forma di infrastruttura più autonoma, controllabile e coerente con lo spirito del progetto.<br><br>

Dal punto di vista della sicurezza e dell'affidabilità tecnica, il server utilizza un'architettura moderna e risulta non direttamente esposto a molte delle principali vulnerabilità hardware note che hanno interessato altri sistemi negli ultimi anni. Anche questo contribuisce a offrire una base più solida per il funzionamento del servizio.<br><br>

<ul>
<li>Il Certificato TLS è stato rilasciato da <a href='https://letsencrypt.org/'>Let's Encrypt</a>, firmato dall'associazione culturale InMediArt.
<li>Il DNS è gestito via <a href='https://www.noip.com/'>NO-IP</a> tramite l'account dell'APS ResponsabItaly.
</ul><br>

<hr>
<h2>Stanze pubbliche</h2>
Le stanze pubbliche rappresentano la forma più libera e immediata di accesso a CitizenRoom. Per entrare non è necessario creare un account, fornire dati personali o installare applicazioni: basta scegliere un <strong>numero di stanza</strong> e un <strong>nickname</strong>. In questo modo chiunque può aprire rapidamente uno spazio di conversazione audio e invitare altri partecipanti semplicemente condividendo un <strong>link di accesso</strong>. È la forma più essenziale di CitizenRoom: una stanza aperta, leggera, pronta all'uso, pensata per favorire la comunicazione diretta tra persone.<br><br>
<br>
<h2>Stanze personalizzate</h2>
Le stanze personalizzate nascono per offrire uno spazio di incontro che possa essere riconosciuto, presentato e condiviso anche all'esterno della piattaforma. In queste stanze è possibile definire un <strong>titolo</strong>, associare un <strong>logo</strong> e inserire un <strong>collegamento a un sito web</strong> personale, associativo o istituzionale. In questo modo la stanza non è soltanto un luogo di accesso alla conversazione, ma può diventare parte integrante della comunicazione di un evento, di un'associazione o di un progetto, attraverso un link di invito da pubblicare e diffondere liberamente sui propri canali web.<br><br>

<br>
<h2>Stanze a tema</h2>
Le stanze a tema sono CitizenRoom che costruiscono l'interfaccia grazie a open data disponibili nella rete (con chiamate live a API pubbliche o con CSV scaricati da siti che li espongono.<br><br>

<h3>Stanze parlamentari</h3>
Le stanze parlamentari sono stanze a tema dedicate ai parlamentari: ogni stanza si costruisce attorno a dati pubblici di un deputato.<br/>
CitizenRoom espone le stanze parlamentari per 3 parlamenti:
<ul>
<li><b>Parlamento Europeo</b>, sorgente dei dati : <a href='https://data.europarl.europa.eu/fr/datasets/deputes-au-parlement-europeen-legislature10/58'>data.europarl.europa.eu</a></li>
<li><b>Parlamento Italiano (Camera dei deputati)</b>, sorgente dei dati : <a href='https://dati.camera.it/'>dati.camera.it</a></li>
<li><b>Parlamento Francese (Assemblée Nationale)</b>, sorgente dei dati : <a href='https://data.assemblee-nationale.fr/acteurs/deputes-en-exercice'>data.assemblee-nationale.fr</a></li>
</ul>
<br>

<h3>Stanze municipali</h3>
Le stanze municipali sono stanze a tema dedicate alle municipalità: ogni stanza si costruisce attorno a dati pubblici di un comune.<br/>
CitizenRoom espone le stanze municipali per 2 paesi:
<ul>
<li><b>Comuni italiani</b>, sorgente dei dati : <a href='https://github.com/Samurai016/Comuni-ITA'>Comuni ITA API</a>, <a href='https://dait.interno.gov.it/elezioni/open-data/amministratori-locali-e-regionali-in-carica'>dait.interno.gov.it - Amministratori locali</a></li>
<li><b>Comuni francesi</b>, sorgente dei dati : <a href='https://geo.api.gouv.fr/'>geo.api.gouv.fr</a>, <a href='https://www.data.gouv.fr/datasets/repertoire-national-des-elus-1/'>data.gouv.fr - Répertoire national des élus</a></li>
</ul>
<br>
<hr>
<br>
<h2>Lavagna collaborativa</h2>
Ogni stanza da accesso ad una lavagna collaborativa, condivisa con tutti gli utenti della stanza.
Questa funzionalità è resa possibile grazie al progetto Open Source <a href='https://wbo.ophir.dev/'>WBO</a> dello sviluppatore <a href='https://ophir.dev/'>Ophir LOJKINE</a>.<br><br>
<br>
<hr>
<br>
<h2>Un prototipo Open Source</h2>
CitizenRoom è un prototipo di piattaforma per conferenze web, basato sull'API pubblica di <a href='https://meet.jit.si/'>Jitsi Meet</a>, scritto in PHP/Javascript e completamente Open Source.<br>
Il codice del prototipo potete leggerlo e eventualmente proporre di modificarlo su GitHub nel <a href='https://github.com/gvincenzi/citizenroom'>repository dedicato</a>.<br><br>
<br>
<hr>
<br>

<h2>Finanziamento del progetto</h2>
CitizenRoom nasce anche come esperimento di autonomia digitale: dimostrare che uno strumento di comunicazione semplice, pubblico nel suo spirito, aperto nel codice e non fondato sulla raccolta dei dati personali può esistere anche al di fuori delle grandi piattaforme commerciali.<br><br>

La piattaforma è sostenuta economicamente dalle associazioni culturali <strong><a href='https://www.responsabitaly.org'>ResponsabItaly</a></strong>, <strong><a href='https://www.inmediart.ovh'>InMediArt</a></strong> e <strong><a href='https://www.assoetica.it'>AssoEtica</a></strong>, che ne condividono l'impostazione culturale e l'obiettivo di costruire strumenti di comunicazione più liberi, sobri e accessibili.<br><br>

Per gli anni <strong>2025</strong> e <strong>2026</strong>, i costi complessivi sostenuti per CitizenRoom sono stati pari a <strong>300 euro IVA compresa</strong>.<br><br>

Si tratta di una cifra volutamente contenuta, che vuole affermare un principio prima ancora che un modello tecnico: è possibile realizzare e mantenere un'infrastruttura essenziale di comunicazione collettiva con risorse limitate, senza ricorrere alla pubblicità, alla profilazione degli utenti o alla dipendenza da ecosistemi proprietari. In questo senso CitizenRoom non è soltanto un prototipo tecnologico, ma anche una piccola proposta politica e culturale: restituire ai cittadini uno spazio di comunicazione diretto, leggero e governabile.<br><br>


");
?>
