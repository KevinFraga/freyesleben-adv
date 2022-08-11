const connect = require('./connection');

const getAll = async () => {
  const [data] = await connect.query(
    'SELECT p.id, u.name, p.title, p.text, DATE_FORMAT(p.created_at, "%d/%m/%y") AS date FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY p.id DESC;'
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

module.exports = {
  getAll,
  registerPost,
  deletePost,
};
