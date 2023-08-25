import React, { useState, useEffect } from 'react';
import DashboardLayout from './DashboardLayout';
import DashboardCards from './DashboardCards';
import { get } from '../helpers/api';
import { toast } from 'react-toastify';
import { useToken } from '../context/TokenContext';

interface DashboardStats {
  currency: string;
  followers_gained: number;
  revenue: {
    donations: number;
    merch_sales: number;
    subscriptions: number;
  };
  top_items: [];
}

const Dashboard: React.FC = () => {
  const { token } = useToken();

  const [dashboardStats, setDashboardStats] = useState<
    DashboardStats | undefined
  >(undefined);

  const loadDashboardStats = async () => {
    try {
      const response = await get('user/dashboard', token);

      if (!response) throw new Error('Error while processing your request.');

      setDashboardStats(response.data);

      console.log(response);
    } catch (e) {
      toast((e as Error).message);
    }
  };

  useEffect(() => {
    if (token) {
      loadDashboardStats();
    }
  }, [token]);

  return (
    <DashboardLayout>
      {dashboardStats && (
        <DashboardCards
          currency={dashboardStats.currency}
          followers_gained={dashboardStats.followers_gained}
          donations={dashboardStats.revenue.donations}
          merch_sales={dashboardStats.revenue.merch_sales}
          subscriptions={dashboardStats.revenue.subscriptions}
          top_items={dashboardStats.top_items}
        />
      )}
    </DashboardLayout>
  );
};

export default Dashboard;

// <div className="min-h-screen flex items-center justify-center bg-purple-900">
//   <div className="bg-purple-200 p-10 rounded-xl shadow-md w-96">
//     <h1 className="text-3xl font-bold mb-4 text-purple-900">Welcome!</h1>
//     <p className="text-purple-900 mb-6" onClick={() => setToken(null)}>
//       Dashboard
//     </p>
//   </div>
// </div>
