import React, { Component } from 'react';
import Youtube from 'react-youtube';
import '../styles/video.css';

class Videoplayer extends Component {
  constructor() {
    super();
    this.state = {
      video: '0mHA_MmDCrU',
    };
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { video } = this.state;
    const opts = {
      playerVars: {
        autoplay: false,
      },
    };

    return (
      <div>
        {this.backlogo()}
        <div className="titleBox">
          <p className="title">Nossas Lives</p>
          <p className="subtitle">Fique por dentro</p>
        </div>
        <div className="video-container">
          <Youtube videoId={video} opts={opts} className="video" />
        </div>
      </div>
    );
  }
}

export default Videoplayer;
