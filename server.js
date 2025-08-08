const express = require('express');
const mongoose = require('mongoose');
const app = express();
const port = 3007;

// Connect to MongoDB
mongoose.connect('mongodb://localhost:27017/mydatabase', {
  useNewUrlParser: true,
  useUnifiedTopology: true
});
const db = mongoose.connection;
db.on('error', console.error.bind(console, 'MongoDB connection error:'));
db.once('open', () => {
  console.log('Connected to MongoDB');
});

// Create a schema for the user
const userSchema = new mongoose.Schema({
  name: String,
  email: String,
  password: String
});

// Create a model based on the schema
const User = mongoose.model('User', userSchema);

// Parse incoming JSON data
app.use(express.json());

// Handle POST requests to /signup
app.post('/signup', async (req, res) => {
  const { name, email, password } = req.body;
  try {
    const newUser = new User({ name, email, password });
    await newUser.save();
    res.status(201).send('User created successfully');
  } catch (err) {
    console.error(err);
    res.status(500).send('Failed to create user');
  }
});

// Start the server
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
