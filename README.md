<b>Home: </b><br>
![Home](https://user-images.githubusercontent.com/95127322/203840389-c52400f7-05cb-4af9-8d2a-5bbe5b04fe9b.JPG)

<b>Card: </b><br>
![Card](https://user-images.githubusercontent.com/95127322/203840623-9cc3731c-9b1e-4d5e-81c2-98b865114eb9.JPG)

<b>Detail: </b><br>
![Detail](https://user-images.githubusercontent.com/95127322/203841286-32732c56-0151-4cc6-9947-b84c53b39537.JPG)

<b>Registration: </b><br>
![Registation](https://user-images.githubusercontent.com/95127322/203840843-7b447dc1-c9d5-4009-b43a-d21eb897faba.JPG)

<b>Login: </b><br>
![Login](https://user-images.githubusercontent.com/95127322/203841050-30a32f3a-d526-4493-8589-3fca352e52e2.JPG)

<b>Cart: </b><br>
![Cart](https://user-images.githubusercontent.com/95127322/203841363-ae2903d6-6a6d-4154-a914-ce86c03daca3.JPG)

<b>Order: </b><br>
![Order](https://user-images.githubusercontent.com/95127322/203841447-e0d9bb67-80e5-4c9c-8c8a-01169b93ebf7.JPG)

<b>Prooducts: </b><br>
![Products](https://user-images.githubusercontent.com/95127322/203841507-ce5c4b46-38ff-42aa-b405-d96eb52a2842.JPG)

<b>Add: </b><br>
![Add](https://user-images.githubusercontent.com/95127322/203841625-e4c8f473-071e-43d5-8bc1-d0bee8ca5378.JPG)


<b>In Documenti è presente la relazione del progetto con le tecnologie utilizzate e alculi screenshot dell'e-commerce.</b>


Questo è un progetto [Next.js](https://nextjs.org/) avviato con [`create-next-app`](https://github.com/vercel/next.js/tree/canary/packages /crea-app successiva).

## Getting Started

Innanzitutto, bisogna scaricare l'applicativo [Xampp](https://www.apachefriends.org/download.html) con i seguenti moduli:

-[Apache](https://www.apache.org/),

-[MySql](https://www.mysql.com/). 

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
