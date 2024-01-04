//get the form by its id
const form = document.getElementById("contact_form"); 

const formEvent = form.addEventListener("submit", (event) => {
    event.preventDefault();
    let mail = new FormData(form);

    sendMail(mail);
})

const sendMail = (mail) => {
    fetch("/send", {
        method: "post", 
        body: mail, 

    }).then((response) => {
        return response.json();
    });
};

const express = require("express");
const nodemailer = require("nodemailer");
const multiparty = require("multiparty");
require("dotenv").config();

// instantiate an express app
const app = express();

//make the contact page the the first page on the app
app.route("/").get(function (req, res) {
  res.sendFile(process.cwd() + "../html/contact.html");
});

//port will be 5000 for testing
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`Listening on port ${PORT}...`);
});


var transporter = nodemailer.createTransport({
    host: "sandbox.smtp.mailtrap.io",
    port: 2525,
    auth: {
      user: "363a1dc9b7e086",
      pass: "a671daa15b1a7d"
    }
});

// verify connection configuration
transporter.verify(function (error, success) {
    if (error) {
      console.log(error);
    } else {
      console.log("Server is ready to take our messages");
    }
  });

  app.post("/send", (req, res) => {
        //1.
        let form = new multiparty.Form();
        let data = {};
        form.parse(req, function (err, fields) {
        console.log(fields);
        Object.keys(fields).forEach(function (property) {
            data[property] = fields[property].toString();
        });
    
        //2. You can configure the object however you want
        const mail = {
            from: data.name,
            to: process.env.EMAIL,
            subject: data.subject,
            text: `${data.name} <${data.email}> \n${data.message}`,
        };
    
        //3.
        transporter.sendMail(mail, (err, data) => {
            if (err) {
            console.log(err);
            res.status(500).send("Something went wrong.");
            } else {
            res.status(200).send("Email successfully sent to recipient!");
            }
        });
    });
});
  