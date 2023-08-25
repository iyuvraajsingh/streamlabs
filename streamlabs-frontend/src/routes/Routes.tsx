import React from 'react';
import {
  BrowserRouter,
  Navigate,
  Route,
  Routes as RouterRoutes,
} from 'react-router-dom';
import Home from '../screens/Home';

const Routes: React.FC = () => {
  return (
    <BrowserRouter>
      <RouterRoutes>
        <Route path="/" element={<Home />} />
        <Route path="*" element={<Navigate to="/" />} />
      </RouterRoutes>
    </BrowserRouter>
  );
};

export default Routes;
