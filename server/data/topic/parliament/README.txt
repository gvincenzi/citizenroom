Request for https://dati.camera.it/sparql

#### tutti i deputati in carica nella XIX Legislatura con info e numero totale di mandati

SELECT DISTINCT ?persona as ?uid ?nome as ?firstname ?cognome as ?lastname
?lista as ?region ?tipoElezione as ?departement ?collegio as ?circonscription ?info as ?profession ?nomeGruppo as ?group ?sigla as ?group_short
WHERE {
?persona ocd:rif_mandatoCamera ?mandato; a foaf:Person.

## deputato
?d a ocd:deputato;
ocd:rif_leg <http://dati.camera.it/ocd/legislatura.rdf/repubblica_19>;
ocd:rif_mandatoCamera ?mandato.
OPTIONAL{?d ocd:aderisce ?aderisce} 
OPTIONAL{?d dc:description ?info}

##anagrafica
?d foaf:surname ?cognome; foaf:gender ?genere;foaf:firstName ?nome.
OPTIONAL{
?persona <http://purl.org/vocab/bio/0.1/Birth> ?nascita.
?nascita <http://purl.org/vocab/bio/0.1/date> ?dataNascita;
rdfs:label ?nato; ocd:rif_luogo ?luogoNascitaUri.
?luogoNascitaUri dc:title ?luogoNascita.
}

##aggiornamento del sistema
OPTIONAL{?d <http://lod.xdams.org/ontologies/ods/modified> ?aggiornamento.}

## mandato
?mandato ocd:rif_elezione ?elezione. 
MINUS{?mandato ocd:endDate ?fineMandato.}
 
## totale mandati
?persona ocd:rif_mandatoCamera ?madatoCamera.

## elezione
OPTIONAL {
?elezione dc:coverage ?collegio
}
OPTIONAL {
?elezione ocd:lista ?lista.
?elezione ocd:tipoElezione ?tipoElezione.
}

## adesione a gruppo
OPTIONAL{
  ?aderisce ocd:rif_gruppoParlamentare ?gruppo.
  ?gruppo <http://purl.org/dc/terms/alternative> ?sigla.
  ?gruppo dc:title ?nomeGruppo.
}
 
}