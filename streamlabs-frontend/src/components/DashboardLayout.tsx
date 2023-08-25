import React from 'react';

interface DashboardLayoutProps {
  children: React.ReactNode;
}

const DashboardLayout: React.FC<DashboardLayoutProps> = ({ children }) => {
  return (
    <div className="flex justify-center min-h-screen bg-gray-200 text-gray-800 ">
      <div className="p-4 w-full bg-purple-900">
        <div className="px-10 mt-5 mb-6">
          <h1 className="text-white text-2xl font-bold ">Stream Labs</h1>
          <h1 className="text-white text-sm font-light">
            by Yuvraj Singh (me@iyuvraajsingh.com)
          </h1>
        </div>

        {children}
      </div>
    </div>
  );
};

export default DashboardLayout;
