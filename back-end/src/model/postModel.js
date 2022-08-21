const connect = require('./connection');

const nodemailer = require('nodemailer');

const getAllPosts = async () => {
  const [data] = await connect.query(
    'SELECT p.id, p.author_id, u.name, p.title, p.text, DATE_FORMAT(p.created_at, "%d/%m/%y") AS date FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY p.id DESC;'
  );

  return data;
};

const registerPost = async (postData) => {
  const { title, text } = postData;

  const [_data] = await connect.query(
    'INSERT INTO posts(author_id, title, text, created_at) VALUES (1, ?, ?, curdate());',
    [title, text]
  );

  return postData;
};

const deletePost = async (postId) => {
  const [data] = await connect.query('DELETE FROM posts WHERE id = ?;', [
    postId,
  ]);

  return data;
};

const getAllFeedbacks = async () => {
  const [data] = await connect.query(
    'SELECT f.id, f.author_id, u.name, f.title, f.text, DATE_FORMAT(f.created_at, "%d/%m/%y") AS date FROM feedbacks f INNER JOIN users u ON f.author_id = u.id ORDER BY f.id DESC;'
  );

  return data;
};

const registerFeedback = async (postData) => {
  const { title, text, userId } = postData;

  const [_data] = await connect.query(
    'INSERT INTO feedbacks(author_id, title, text, created_at) VALUES (?, ?, ?, curdate());',
    [userId, title, text]
  );

  return postData;
};

const deleteFeedback = async (postId) => {
  const [data] = await connect.query('DELETE FROM feedbacks WHERE id = ?;', [
    postId,
  ]);

  return data;
};

const sendEmail = async (emailData) => {
  const { name, subject, email, text } = emailData;

  const testEmail = await nodemailer.createTestAccount();

  const transporter = nodemailer.createTransport({
    host: "smtp.ethereal.email",
    port: 587,
    secure: false,
    auth: {
      user: testEmail.user,
      pass: testEmail.pass,
    },
  });

  const mailOptions = {
    from: email,
    to: 'freyesleben.adv@gmail.com',
    subject: subject,
    html: `<p>${text}</p><p>Enviado por ${name}</p>`,
  };

  const answer = await transporter.sendMail(mailOptions);

  const url = nodemailer.getTestMessageUrl(answer);

  console.log(url);
};

module.exports = {
  getAllPosts,
  registerPost,
  deletePost,
  getAllFeedbacks,
  registerFeedback,
  deleteFeedback,
  sendEmail,
};
