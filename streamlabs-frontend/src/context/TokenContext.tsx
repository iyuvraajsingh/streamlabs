import React, { createContext, useContext, useEffect, useState } from 'react';
import Cookies from 'js-cookie';

export const TokenContext = createContext<any>(null);

export const TokenProvider: React.FC = ({ children }: any) => {
  const [token, setToken] = useState<string | null>(
    () => Cookies.get('jwtToken') || null
  );

  useEffect(() => {
    if (token) {
      Cookies.set('jwtToken', token, { expires: 1 / 24 });
    } else {
      Cookies.remove('jwtToken');
    }
  }, [token]);

  return (
    <TokenContext.Provider value={{ token, setToken }}>
      {children}
    </TokenContext.Provider>
  );
};

export const useToken = () => {
  const context = useContext(TokenContext);
  if (!context) {
    throw new Error('useToken must be used within a TokenProvider');
  }
  return context;
};
