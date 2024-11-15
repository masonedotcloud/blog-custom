# Blog-Custom

Benvenuti nel repository del sito web **blog-custom**. Questo progetto rappresenta un sito web personalizzato sviluppato con **PHP**, **AJAX** e **Bootstrap**.

## Caratteristiche principali

- **Dinamico:** Caricamento dei contenuti tramite AJAX per un'esperienza utente fluida e veloce.
- **Responsive:** Interfaccia utente ottimizzata per dispositivi desktop, tablet e mobile grazie a Bootstrap.
- **Personalizzabile:** Struttura modulare per una facile configurazione e personalizzazione.



## Requisiti di sistema

Prima di procedere con l'installazione e la configurazione del sito, assicurarsi che l'ambiente server soddisfi i seguenti requisiti:

- **PHP:** Versione 8 o superiore
- **Web Server:** Apache (o equivalente compatibile con .htaccess)
- **Browser:** Compatibile con HTML5, CSS3 e JavaScript



## Guida alla configurazione

Segui questi passaggi per configurare correttamente il sito web:

### 1. Percorso del sito
Se il sito è ospitato in una sottodirectory, sostituire `'/blog-custom'` con il percorso relativo corretto.  
Ad esempio:  
- Directory radice del server: lasciare vuoto.  
- Directory personalizzata: `/subdirectory_name/blog-custom`.

### 2. Configurazione di `.htaccess`
Assicurarsi che il file `.htaccess` sia presente e configurato per gestire il reindirizzamento delle URL. Verificare che il server supporti la riscrittura delle URL (mod_rewrite abilitato).

Esempio di regola `.htaccess`:
```apache
RewriteEngine On
RewriteBase /blog-custom/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### 3. Impostazioni server
Controllare che le seguenti variabili del server siano configurate correttamente:
- **`$_SERVER['DOCUMENT_ROOT']`:** Deve puntare alla root del sito.
- **Estensioni PHP:** Assicurarsi che siano abilitate le estensioni richieste da PHP, come `PDO` e `mbstring`.

### 4. Verifica dell'ambiente
- Caricare il file `phpinfo()` per verificare la versione di PHP e le configurazioni.
- Controllare che i permessi delle cartelle siano configurati per consentire la lettura e scrittura dei file necessari.



## Struttura del progetto

La struttura principale del progetto è organizzata come segue:

```
blog-custom/
│
├── assets/               # File statici (CSS, JS, immagini)
├── includes/             # Componenti riutilizzabili (header, footer, ecc.)
├── templates/            # Template delle pagine principali
├── .htaccess             # Configurazione URL rewrite
├── config.php            # Configurazione principale del sito
├── index.php             # Punto di ingresso principale
└── README.md             # Documentazione del progetto
```



## Licenza

Questo progetto è distribuito sotto la Licenza MIT - vedi il file [LICENSE](LICENSE) per ulteriori dettagli.


## Autore

Questo progetto è stato creato da [alessandromasone](https://github.com/alessandromasone).