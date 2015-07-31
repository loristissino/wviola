**This should be translated into English**

# Gestione degli asset #

## Tipi di asset ##

Si possono archiviare con Wviola diversi tipi di asset:

  * video (_video_)
  * immagini (_picture_)
  * collezioni di fotografie (_photoalbum_)
  * registrazioni audio (_audio_)

## Degradazione dei file ##

Le considerazioni che seguono valgono in misura preponderante per i file video, anche se in parte possono essere applicate agli altri tipi di asset.

I file da archiviare provengono da registrazioni in formato DV o MPEG e vanno archiviati su DVD-ROM. Per i fini che ci si è posti con questo progetto, non è necessario che vengano archiviati i file video originali, ma è sufficiente che vengano archiviate delle copie con un buon rapporto qualità/peso e una risoluzione uguale o simile all'originale.

Nella terminologia di Wviola, si parla di:

  * sorgente (_source_), con riguardo al file originale, che **non verrà mantenuto**
  * file ad alta qualità (_highquality_), con riguardo al file che verrà memorizzato su DVD-ROM e sarà fruibile solo _off-line_
  * file a bassa qualità (_lowquality_), con riguardo al file che verrà messo a disposizione per la fruizione permanente _on-line_

Ad esempio, un esperimento effettuato con un file video di circa 53 minuti ha mostrato questi valori:

  * la versione originale è di circa 1,9 GiB (formato MPEG2)
  * la versione ad alta qualità per il backup è di circa 420 MiB (formato Ogg Theora)
  * la versione a bassa qualità per lo streaming è di circa 147 MiB (formato Flash Video)

Naturalmente, le versioni ad alta qualità e a bassa qualità possono avere versioni diverse a seconda delle impostazioni per la codifica e la compressione (bitrate, dimensioni del frame, ecc.).

![http://wviola.googlecode.com/svn/wiki/compressione.png](http://wviola.googlecode.com/svn/wiki/compressione.png)

I tempi di codifica si sono aggirati sui 100 minuti per la versione ad alta qualità e sui 12 minuti per quella a bassa qualità.

Del file originale vengono archiviate nel database alcune informazioni (data del file, dimensione, hash md5), in modo da avere la possibilità di fare alcune statistiche e, soprattutto, di evitare che uno stesso file venga archiviato più volte.

## Procedura seguita per l'archiviazione ##

Questa è una descrizione sommaria dei passi seguiti per l'archiviazione di un asset:

  * Inizio procedura
    1. individuazione di un file tra quelli destinati all'archiviazione (nella directory indicata alla voce `directory_sources` del file _wviola.yml_)
    1. indicazione delle parole chiave e di altri attributi
    1. avvio della procedura di archiviazione
    1. (viene creata una voce nella base di dati, con status posto a 1)
    1. (il file sorgente viene spostato nella directory indicata alla voce `directory_scheduled` del file _wviola.yml_ e rinominato con un id standardizzato, denominato _slug_)

  * Generazione dei file ad alta e bassa qualità
    1. un apposito task individua il file da convertire
    1. (dal file _source_ si ottengono il file _highquality_ e il file _lowquality_)
    1. (il file _source_ viene eliminato)
    1. (il file _highquality_ viene spostato nella directory indicata alla voce `directory_iso_cache` del file _wviola.yml_)
    1. (il file _lowquality_ viene spostato nella directory indicata alla voce `directory_published` del file _wviola.yml_)
    1. (per la corrispondente voce nella base di dati lo status viene posto a 2)

  * Generazione delle immagini ISO dei DVD-ROM
    1. un apposito task individua il momento in cui la directory indicata alla voce `directory_iso_cache` del file _wviola.yml_ contiene un numero di file sufficiente per procedere all'archiviazione esterna
    1. (viene generata l'immagine ISO di un DVD-ROM contenente i file posti nella directory)
    1. (l'immagine ISO viene posta nella directory indicata alla voce `directory_iso_images` del file _wviola.yml_)
    1. (per tutti gli asset i cui file sono stati posti nell'immagine ISO viene indicato l'id dell'immagine ISO corrispondente, e lo status viene posto a 3)
    1. (dopo gli opportuni controlli di correttezza dell'immagine ISO ottenuta, tutti i file della _cache_ che sono stati posti nell'immagine ISO vengono rimossi)
    1. (il sistemista viene informato che l'immagine ISO è pronta per essere masterizzata)

  * Produzione materiale dei DVD-ROM (masterizzazione)
    1. il sistemista masterizza l'immagine ISO e verifica l'integrità del DVD-ROM ottenuto
    1. il sistemista aggiorna la base di dati, indicando data e ora di masterizzazione del DVD-ROM
    1. il sistemista, se lo desidera, rimuove l'immagine ISO del DVD-ROM, oppure la sposta su altro filesystem
    1. (per gli asset coinvolti lo status viene posto a 4)

Ricapitolando, per gli asset lo status può essere uno dei seguenti:

| **stato** | **descrizione** |
|:----------|:----------------|
| 1         | programmato per l'archiviazione, in attesa |
| 2         | archiviato su disco, disponibile per la fruizione on-line a bassa qualità |
| 3         | archiviato in una immagine ISO pronta per la masterizzazione, disponibile per la fruizione on-line a bassa qualità |
| 4         | archiviato su DVD-ROM masterizzato, disponibile per la fruizione on-line a bassa qualità |
