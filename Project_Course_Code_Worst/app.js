// App.js

var express = require("express"),
	passport = require("passport"),
	bodyParser = require("body-parser"),
	LocalStrategy = require("passport-local"),
	passportLocalMongoose =
		require("passport-local-mongoose")
const User = require("./model/User");

var MongoClient = require('mongodb').MongoClient;

const uri = "mongodb://127.0.0.1:27017/";


const contactSchema = {
    username: String,
    passwd: String,
 }; 


var app = express();
var path=require('path');
// const { default: mongoose } = require("mongoose");



app.set("view engine", "ejs");
app.use(bodyParser.urlencoded({ extended: true }));
app.use(require("express-session")({
	secret: "Rusty is a dog",
	resave: false,
	saveUninitialized: false
}));

app.use(passport.initialize());
app.use(passport.session());

app.use(express.static(path.join(__dirname, 'public')));

passport.use(new LocalStrategy(User.authenticate()));
passport.serializeUser(User.serializeUser());
passport.deserializeUser(User.deserializeUser());

//=====================
// ROUTES
//=====================

// Showing home page
app.get("/", function (req, res) {
	res.render("gen_home");
});

// Showing secret page
app.get("/home", isLoggedIn, function (req, res) {
	res.render("home");
});

//showing order page
app.get("/order", function (req, res) {
	res.render("order");
});

//showing earnings page
app.get("/earnings", function (req, res) {
	res.render("earnings");
});

//showing myprofile page
app.get("/myprofile", function (req, res) {
	res.render("myprofile");
});

// Showing register form
app.get("/register", function (req, res) {
	res.render("register");
});

// Handling user signup
// app.post("/register", async (req, res) => {
// 	const user = await User.create({
// 	username: req.body.username,
// 	passwd: req.body.password
// 	});
	
// 	return res.status(200).json(user);
// });


app.post("/register", async (req, res) => {
    //console.log(req.body.username);

//   console.log(req.body.username);
//   console.log(req.body.passwd);
//   contact.save(function (err) {
//       if (err) {
//           throw err;
//       } else {
//         res.render("secret");
//       }
//   });
//   let output;
//   (async () => {
//     //await contact.username.create();
//     //await contact.passwd.create();
//     await output.insertOne(contact);
//   })
//   res.render("secret");
    const client = new MongoClient(uri);

    async function run() {
        try {
          const database = client.db("ArthouseMain");
          const haiku = database.collection("users");
          // create a document to insert
          const doc = {
            username: req.body.username,
            password: req.body.passwd,
          }
          const result = await haiku.insertOne(doc);
          console.log(`A document was inserted with the _id: ${result.insertedId}`);
        } finally {
          await client.close();
        }
      }
      run().catch(console.dir);

  res.render("home");

    });



//Showing login form
app.get("/login", function (req, res) {
	res.render("login");
});

//Handling user login
app.post("/login", async function(req, res){

    const client = new MongoClient(uri);
    async function run() {
        try {
          const database = client.db("ArthouseMain");
          const haiku = database.collection("users");
          
          const user = await haiku.findOne({ username: req.body.username });
          
          if(user) 
          {
                //check if password matches
                const result = req.body.password == user.passwd;
                
                //const result = await bcrypt.compare(req.body.password, user.passwd);
                if (result) {
                    res.render("home");
                } 
                else 
                {
                    res.status(400).json({ error: "password doesn't match" });
                }
		      }
          else 
          {
		        res.status(400).json({ error: "User doesn't exist" });
		      } 
          
        } finally {
          await client.close();
        }
      }
      run().catch(console.dir);

});

//Handling user logout
app.get("/logout", function (req, res) {
	req.logout(function(err) {
		if (err) { return next(err); }
		res.redirect('/');
	});
});



function isLoggedIn(req, res, next) {
	if (req.isAuthenticated()) return next();
	res.redirect("/home");
}

var port = process.env.PORT || 3000;
app.listen(port, function () {
	console.log("Server Has Started!");
});
