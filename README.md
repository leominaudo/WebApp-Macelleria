Questo è un progetto [Next.js](https://nextjs.org/) avviato con [`create-next-app`](https://github.com/vercel/next.js/tree/canary/packages /crea-app successiva).

## Getting Started

Innanzitutto, bisogna scaricare l'applicativo [Xampp](https://www.apachefriends.org/download.html) con i seguenti moduli:

-[Apache](https://www.apache.org/),

-[MySql](https://nextjs.org/). 

Dopo, bisogna attiviare i due moduli, aprire dal browser la dashboard di [phpMyAdmin](https://skillforge.com/how-to-create-a-database-using-phpmyadmin-xampp/), 
andare nella sezione crea nuovo database, andare nel tab IMPORT selezionare il file [macelleria.sql](https://github.com/leominaudo/WebApp-Macelleria/blob/main/macelleria.sql), deselezionare il flag su opzioni specifiche al formato ed infine lanciare l'esecuzione.

A questo punto è stato creato il database, 
ora bisogna aggiungere i file presenti nella directory ```api/``` all'interno della document root di xampp al seguente path: 
```C:\("path di installazione")\xampp\htdocs\api\```, questo passaggio è fondamentale perchè in questo modo andiamo a configurare la connessione al nostro DB e ad aggiungere tutti gli endpoint che sono stati implementati nel file index.php .

Infine, basta clonare la repository in locale aprirla con un IDE (es. Visual Studio Code), aprire un terminale, posiziornarsi sulla root della repository ed eseguire il comando:
```bash
npm install
npm run dev
# or
yarn install 
yarn dev
```
Apri [http://localhost:3000](http://localhost:3000) con il tuo browser per vedere il risultato.

## Account paypal developer 

Per poter testare il sito, nello specifico per effettuare un ordine, bisogna avere un account paypal developer.
Account di prova: 
- E-mail: sb-l6hgg16300275@personal.example.com
- password: w=M82B24

## Learn More

Per ulteriori informazioni su Next.js, dai un'occhiata alle seguenti risorse:

- [Documentazione Next.js](https://nextjs.org/docs) - scopri le funzionalità e l'API di Next.js.
- [Learn Next.js](https://nextjs.org/learn) - un tutorial interattivo Next.js.

Puoi controllare [il repository GitHub Next.js](https://github.com/vercel/next.js/) - il tuo feedback e i tuoi contributi sono i benvenuti!

## Deploy on Vercel

Il modo più semplice per distribuire l'app Next.js è utilizzare la [Piattaforma Vercel](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app -readme) dai creatori di Next.js.

Per maggiori dettagli, consulta la nostra [documentazione sulla distribuzione di Next.js](https://nextjs.org/docs/deployment).
