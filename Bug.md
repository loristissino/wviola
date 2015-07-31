**This should be translated into English**

# Bug noti #

  1. [RISOLTO](RISOLTO.md) ~~L'interfaccia generata da Symfony con l'admin generator (nel backend) ha un problema che si verifica quando si fa clic sull'intestazione delle colonne per cambiare l'ordinamento. Viene generato un Segmentation Fault di Apache e si presenta una pagina bianca.~~

  1. [RISOLTO](RISOLTO.md) ~~Il programma `zip` non ammette la versione lunga delle opzioni nelle versioni più vecchie.~~ Sono state usate le opzioni corte.

  1. [RISOLTO](RISOLTO.md) ~~Gli utenti provenienti dalla base di dati LDAP devono poter essere considerati non attivi in base a qualche criterio.~~ Vedere il file _config/app.yml_.

  1. [RISOLTO](RISOLTO.md) ~~Lo script che produce i video si blocca interattivamente quando il file da produrre è già presente. Bisogna forzare l'overwrite.~~ Bisogna inserire l'opzione `-y` per il programma `ffmpeg` (nel file _config/wviola.yml_) e poi rigenerare gli script.

