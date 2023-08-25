import React, { useState } from 'react';
import Notification from './Notification';

const Notifications: React.FC = () => {
  const [showUnreadList, setShowUnreadList] = useState(true);

  const selectedButtonStyle =
    'p-2 border border-slate-200 rounded-md inline-flex space-x-1 items-center text-white hover:text-white bg-purple-600 hover:bg-purple-500';
  const normalButtonStyle =
    'p-2 border border-slate-200 rounded-md inline-flex space-x-1 items-center hover:bg-slate-200';
  return (
    <div className="max-w my-10 bg-white p-8 rounded-md shadow shadow-slate-300 mx-10">
      <div className="flex flex-row justify-between items-center">
        <div>
          <h1 className="text-3xl font-medium">Notifications</h1>
        </div>
        <div className="inline-flex space-x-2 items-center">
          <div
            onClick={() => setShowUnreadList(true)}
            className={showUnreadList ? selectedButtonStyle : normalButtonStyle}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              className="w-4 h-4"
              fill="currentColor"
            >
              <circle cx="12" cy="12" r="9" />
            </svg>
            <span className="text-sm  hidden md:block">Unread</span>
          </div>
          <div
            onClick={() => setShowUnreadList(false)}
            className={
              !showUnreadList ? selectedButtonStyle : normalButtonStyle
            }
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              className="w-4 h-4"
              fill="none"
              stroke="currentColor"
              strokeWidth="1.5"
            >
              <circle cx="12" cy="12" r="9" />
            </svg>
            <span className="text-sm hidden md:block">Read</span>
          </div>
        </div>
      </div>
      <p className="text-slate-500">
        Hello Yuvraj, here are your latest notifications
      </p>
      {showUnreadList && <Notification initialStatus={1} setStatus={0} />}
      {!showUnreadList && <Notification initialStatus={0} setStatus={1} />}
    </div>
  );
};

export default Notifications;
