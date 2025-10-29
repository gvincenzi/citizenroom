<?php 
$cookieDisclaimer = ("
<h2>Che cos'è e perché CitizenRoom?</h2>
Nel 1945 negli Stati Uniti nacque la <strong>Citizens' Band, la banda cittadina</strong>.<br>
CB era uno dei vari servizi radio regolamentati dalla Federal Communications Commission (FCC) per consentire ai cittadini di utilizzare una banda di frequenze radio per la <strong>comunicazione personale</strong> (ad esempio i modellini radiocomandati, le chiacchiere fra parenti ed amici, le piccole imprese) <strong><a href='https://it.wikipedia.org/wiki/Banda_cittadina'> >> fonte Wikipedia</a></strong>.
<br><br>

CitizenRoom nasce con l'idea di riutilizzare lo stesso schema e proporre l'utilizzo di una parte del web in modo libero da qualsiasi rapporto con un intermediario pubblico o privato(a pagamento o gratuito ma in cambio di informazioni personali), sviluppando un servizio di comunicazione audio e video da dedicare alla comunicazione personale tra i cittadini.<br><br>

CitizenRoom è una piattaforma per la creazione di stanze in cui poter poter organizzare delle riunioni (audio e video) con un numero teoricamente illimitato di partecipanti: il prototipo che è attualmente a vostra disposizione permette di invitare fino a <strong>20 persone</strong> per un corretto funzionamento.<br><br>

CitizenRoom è <strong>gratuito, open source e non necessita né della creazione di un conto</strong>, né dell'installazione di applicaziioni (desktop o mobile): potete creare delle stanze liberamente e senza limiti e, utilizzando un tasto che vi genera un link di invito, potrete far partecipare chiunque senza obbligarlo a crearsi un conto o installare un software sul suo dispositivo.<br>

Abbiamo sentito l'esigenza di creare e testare una piattaforma che puntasse piuttosto sulla <strong>semplicità</strong> che sulla personalizzazione del servizio.<br><br>

<h2>Gestione dei dati</h2>
CitizenRoom non salva <strong>nessun dato degli utenti, dei dispositivi, della conversazione</strong>. Questo non significa che CitizenRoom sia un'applicazione in cui poter godere di un totale anonimato, al contrario: CitizenRoom è una piattaforma <strong>libera ma non cifrata</strong>, quindi in ogni momento, in caso di scambio di informazioni scorretto e/o illegale, <strong>ogni conversazione potrà essere monitorata da un'autorità competente</strong>.<br>
CitizenRoom vuole essere un mezzo semplice e immediato, ma non uno strumento di offuscamento della propria identità per fini illeciti e contrari alla legge dello Stato in cui la piattaforma è situata e da cui gli utenti si connettono.<br><br>

<h2>Self hosted Jitsi Meet</h2>
Citizenroom usa un Jitsi Meet Server self hosted <a href='https://citizenroom.ddns.net'>qui</a> :<br>
<ul>
<li>Il Certificato TLS è stato rilasciato da <a href='https://letsencrypt.org/'>Let's Encrypt</a>, firmato dall'associazione culturale InMediArt.
<li>Il DNS è gestito via <a href='https://www.noip.com/'>NO-IP</a> tramite l'account dell'APS ResponsabItaly.
</ul><br>

<h2>Lavagna collaborativa</h2>
Ogni stanza da accesso ad una lavagn collaborativa, condivisa con tutti gli utenti della stanza.
Questa funzionalità è resa possibile grazie al progetto Open Source <a href='https://wbo.ophir.dev/'>WBO</a> dello sviluppatore <a href='https://ophir.dev/'>Ophir LOJKINE</a>.<br><br>
<br>
<hr>
<br>
<h2>Stanze a tema</h2>
Le stanze a tema sono CitizenRoom che costruiscono l'interfaccia grazie a open data disponibili nella rete (con chiamate live a API pubbliche o con CSV scaricati da siti che li espongono).<br><br>

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
<h2>Un prototipo Open Source</h2>
CitizenRoom è un prototipo di piattaforma per conferenze web, basato sull'API pubblica di <a href='https://meet.jit.si/'>Jitsi Meet</a>, scritto in PHP/Javascript e completamente Open Source.<br>
Il codice del prototipo potete leggerlo e eventualmente proporre di modificarlo su GitHub nel <a href='https://github.com/gvincenzi/citizenroom'>repository dedicato</a>.
<br><br>

");
?>
