require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const userRoutes = require('./src/routes/userRoutes');

const app = express();
app.use(cors());
app.use(bodyParser.json());

app.use('/create-user-service/users', userRoutes);

const PORT = process.env.PORT || 5007;
app.listen(PORT, () => console.log(`Servidor corriendo en http://localhost:${PORT}`));
