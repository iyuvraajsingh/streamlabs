import React from 'react';

type DashboardCardsProps = {
  followers_gained: number;
  currency: string;
  donations: number;
  merch_sales: number;
  subscriptions: number;
  top_items: [];
};

const DashboardCards: React.FC<DashboardCardsProps> = ({
  followers_gained,
  currency,
  donations,
  merch_sales,
  subscriptions,
  top_items,
}) => {
  const total = donations + merch_sales + subscriptions;
  const formattedTotal = total.toFixed(2);

  return (
    <div className="grid grid-cols-12 md:grid-cols-10 gap-4 px-10">
      <div className="col-span-12 sm:col-span-6 md:col-span-2">
        <div className="flex flex-row bg-white shadow-sm rounded p-4">
          <div className="flex items-center justify-center flex-shrink-0 h-16 w-16 rounded-xl bg-blue-100 text-blue-500">
            <svg
              className="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
          </div>
          <div className="flex flex-col flex-grow ml-4">
            <div className="text-sm text-gray-500">Total Revenue</div>
            <div className="font-bold text-lg">
              {formattedTotal} {currency}
            </div>
            <div className="font-normal text-xs text-gray-400">
              in last 30 days
            </div>
          </div>
        </div>
      </div>
      <div className="col-span-12 sm:col-span-6 md:col-span-2">
        <div className="flex flex-row bg-white shadow-sm rounded p-4">
          <div className="flex items-center justify-center flex-shrink-0 h-16 w-16 rounded-xl bg-green-100 text-green-500">
            <svg
              className="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
              ></path>
            </svg>
          </div>
          <div className="flex flex-col flex-grow ml-4">
            <div className="text-sm text-gray-500">New Followers</div>
            <div className="font-bold text-lg">{followers_gained}</div>
            <div className="font-normal text-xs text-gray-400">
              in last 30 days
            </div>
          </div>
        </div>
      </div>
      {top_items.map((e: any, i) => (
        <div className="col-span-12 sm:col-span-6 md:col-span-2">
          <div className="flex flex-row bg-white shadow-sm rounded p-4">
            <div className="flex items-center justify-center flex-shrink-0 h-16 w-16 rounded-xl bg-red-100 text-red-500">
              <svg
                className="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <text
                  x="50%"
                  y="50%"
                  font-size="20"
                  font-family="Arial"
                  text-anchor="middle"
                  dy=".3em"
                >
                  {i + 1}
                </text>
              </svg>
            </div>
            <div className="flex flex-col flex-grow ml-4">
              <div className="text-sm text-gray-500">{e.name}</div>
              <div className="font-bold text-lg">
                {e.total_sales} {currency}
              </div>
              <div className="font-normal text-xs text-gray-400">
                in last 30 days
              </div>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
};

export default DashboardCards;
