import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/uploader.css';

const axios = require('axios').default;

class ProcessHub extends Component {
  constructor() {
    super();
    this.state = {
      processes: [],
      loading: true,
    };
  }

  componentDidMount() {
    const { userId } = this.props;

    axios
      .get(`http://localhost:3007/user/${userId}/process`)
      .then((response) => {
        this.setState({ processes: response.data, loading: false });
      });
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { processes, loading } = this.state;
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          {!loading &&
            processes.map((process) => (
              <div key={process.process} className="download-container">
                <div className="d-text">
                  <p>Processo {process.process}</p>
                </div>
                <Link to={process.process} className="process-button">
                  <p>Detalhes</p>
                </Link>
              </div>
            ))}
        </div>
      </div>
    );
  }
}

export default ProcessHub;
