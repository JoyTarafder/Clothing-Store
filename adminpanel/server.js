const express = require("express");
const mongoose = require("mongoose");
const bodyParser = require("body-parser");
const cors = require("cors");
require("dotenv").config();

const app = express();
const PORT = process.env.PORT || 5000;

// Middleware
app.use(bodyParser.json());
app.use(cors());

// Connect to MongoDB
mongoose
  .connect(process.env.MONGO_URI, { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log("MongoDB connected successfully"))
  .catch((err) => console.error("MongoDB connection error:", err));

// Define Vendor Schema and Model
const vendorSchema = new mongoose.Schema({
  name: { type: String, required: true },
  type: { type: String, required: true },
  email: { type: String, required: true },
  contact: { type: String, required: true },
  address: { type: String, required: true },
  comment: { type: String },
});

const Vendor = mongoose.model("Vendor", vendorSchema);

// API Endpoints
app.get("/vendors", async (req, res) => {
  try {
    const vendors = await Vendor.find();
    res.json(vendors);
  } catch (err) {
    res.status(500).send(err.message);
  }
});

app.post("/vendors", async (req, res) => {
  try {
    const newVendor = new Vendor(req.body);
    await newVendor.save();
    res.status(201).json(newVendor);
  } catch (err) {
    res.status(400).send(err.message);
  }
});

app.delete("/vendors/:id", async (req, res) => {
  try {
    await Vendor.findByIdAndDelete(req.params.id);
    res.status(200).send("Vendor deleted");
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// Start the Server
app.listen(PORT, () => console.log(`Server running on http://localhost:${PORT}`));
