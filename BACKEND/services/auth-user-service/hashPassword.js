const bcrypt = require('bcryptjs');

async function hashPassword() {
    const password = "securepassword"; // Cambia esto por la contraseña que quieres cifrar
    const hashed = await bcrypt.hash(password, 10);
    console.log("Contraseña cifrada:", hashed);
}

hashPassword();
