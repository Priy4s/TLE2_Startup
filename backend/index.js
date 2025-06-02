import express from 'express';

const app = express();
const port = 3000;

app.use(express.json());

app.get('/', (req, res) => {
    res.send('Hallo dit is express');
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
