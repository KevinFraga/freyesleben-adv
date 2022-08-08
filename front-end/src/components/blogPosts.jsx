import React, { Component } from 'react';
import '../styles/curriculum.css';

class BlogPosts extends Component {
  render() {
    return (
      <div>
        <div className="titleBox">
          <p className="title">BLOG DO ADVOGADO</p>
          <p className="subtitle">O que penso sobre...</p>
        </div>
        <div className="post">
          <div className="p-img">
            <p className="p-name">Alexandre Guerrieri Freyesleben</p>
            <img src="/Alexandre_sem_fundo.png" alt="alexandre" />
          </div>
          <div className="p-img">
            <p className="p-name">Título do Post</p>
            <p>08/08/2022</p>
          </div>
          <div className='p-text'>
            <p>Texto do post no blog do advogado</p>
          </div>
        </div>
      </div>
    );
  }
}

export default BlogPosts;
