import React from 'react';
import { GoogleLogin } from '@react-oauth/google';
import { post } from '../helpers/api';
import { toast } from 'react-toastify';
import { useToken } from '../context/TokenContext';

const Login: React.FC = () => {
  const { setToken } = useToken();

  const handleGoogleLoginSuccess = async (credentialResponse: any) => {
    if (!credentialResponse || !credentialResponse.credential) {
      toast('Unable to authenticate, Please try again later.');
    }
    try {
      const response = await post(
        'auth/login',
        {},
        credentialResponse.credential
      );

      const jwtToken = response.data.token;
      setToken(jwtToken);
    } catch (e) {
      toast((e as Error).message);
    }
  };

  const handleGoogleLoginError = () => {
    toast('Login Failed');
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-purple-900">
      <div className="bg-purple-200 p-10 rounded-xl shadow-md w-96">
        <h1 className="text-3xl font-bold mb-4 text-purple-900">Welcome!</h1>
        <p className="text-purple-900 mb-6">
          Please login with your Google account.
        </p>

        <GoogleLogin
          onSuccess={handleGoogleLoginSuccess}
          onError={handleGoogleLoginError}
        />
      </div>
    </div>
  );
};

export default Login;
