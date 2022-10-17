import axios from 'axios';
import React, { Component } from 'react';
import { useParams } from 'react-router-dom';
import '../styles/curriculum.css';

function withParams(Component) {
  return (props) => <Component {...props} params={useParams()} />;
}

class Process extends Component {
  constructor() {
    super();
    this.state = {
      step: '',
      stage: 0,
      color: 'green',
      documentation: 0,
      loading: true,
    };
  }

  componentDidMount() {
    const { userId, params } = this.props;

    axios
      .get(`http://localhost:3007/user/${userId}/process/${params.process}`)
      .then((response) => {
        const { step, stage, color, documentation } = response.data;
        this.setState({ step, stage, color, documentation, loading: false });
      });
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { step, stage, color, documentation, loading } = this.state;
    const { name } = this.props;

    const progress = { width: `${documentation}%` };
    const colored = { backgroundColor: color };

    return (
      <div>
        {this.backlogo()}
        <h1 className="user-name">{name}:</h1>
        {stage === 0 && (
          <div className="slider">
            <div className="slidebar" style={progress} />
          </div>
        )}
        {!loading && (
          <div>
            {stage > 0 && (
              <div className="progress-bar">
                <div className="progress-step">
                  <div
                    className="step"
                    style={stage === 1 ? colored : null}
                  />
                  <p className="step-text">Protocolado</p>
                </div>
                <div className="line-step" />
                <div className="progress-step">
                  <div
                    className="step"
                    style={stage === 2 ? colored : null}
                  />
                  <p className="step-text">Sentença</p>
                </div>
                <div className="line-step" />
                <div className="progress-step">
                  <div
                    className="step"
                    style={stage === 3 ? colored : null}
                  />
                  <p className="step-text">Tribunais Superiores</p>
                </div>
                <div className="line-step" />
                <div className="progress-step">
                  <div
                    className="step"
                    style={stage === 4 ? colored : null}
                  />
                  <p className="step-text">Execução</p>
                </div>
              </div>
            )}
            <div className="post">
              <p className="p-text">
                Seu processo encontra-se na seguinte etapa:
              </p>
              <p className="p-text">{step}</p>
            </div>
          </div>
        )}
      </div>
    );
  }
}

export default withParams(Process);
