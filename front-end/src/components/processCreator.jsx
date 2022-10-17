import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class ProcessCreator extends Component {
  constructor() {
    super();
    this.state = {
      process: 'Outros',
      processes: [],
    };
    this.handleSelect = this.handleSelect.bind(this);
    this.handleCreate = this.handleCreate.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:3007/post/processes').then((response) => {
      this.setState({ processes: response.data });
    });
  }

  handleSelect({ target }) {
    this.setState({
      [target.name]: target.value,
    });
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  handleCreate() {
    const { process } = this.state;
    const { userId } = this.props;
    const token = localStorage.getItem('token');

    const headers = { process, userId, token };

    axios
      .post(`http://localhost:3007/user/${userId}/newprocess`, headers)
      .then((response) => {
        alert(response.data.message);
      })
      .catch((error) => {
        alert(error.response.data.message);
      });
  }

  render() {
    const { processes } = this.state;
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          <select name="process" onChange={this.handleSelect}>
            {processes.map((type) => (
              <option key={type.name} value={type.name}>
                {type.name}
              </option>
            ))}
          </select>
          <button
            type="button"
            className="f-button"
            onClick={this.handleCreate}
          >
            Criar Processo
          </button>
        </div>
      </div>
    );
  }
}

export default ProcessCreator;
