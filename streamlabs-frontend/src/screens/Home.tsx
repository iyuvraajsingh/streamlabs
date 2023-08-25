import React from 'react';
import Dashboard from '../components/Dashboard';
import Login from '../components/Login';
import { useToken } from '../context/TokenContext';

const Home: React.FC = () => {
  const { token } = useToken();

  if (token) {
    return <Dashboard />;
  } else {
    return <Login />;
  }
};

export default Home;
