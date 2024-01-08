const { MailtrapClient } = require("mailtrap");

const TOKEN = "5553eea8613e6b9ede9733f5fc497029";
const ENDPOINT = "https://send.api.mailtrap.io/";

const client = new MailtrapClient({ endpoint: ENDPOINT, token: TOKEN });

const sender = {
  email: "mailtrap@lilyannejaczko.com",
  name: "Mailtrap Test",
};
const recipients = [
  {
    email: "lily92415@gmail.com",
  }
];

client
  .send({
    from: sender,
    to: recipients,
    subject: "You are awesome!",
    text: "Congrats for sending test email with Mailtrap!",
    category: "Integration Test",
  })
  .then(console.log, console.error);