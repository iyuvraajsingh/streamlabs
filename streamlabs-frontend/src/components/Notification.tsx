import React, { useState, useEffect } from 'react';
import { get, put } from '../helpers/api';
import { toast } from 'react-toastify';
import { useToken } from '../context/TokenContext';
import InfiniteScroll from 'react-infinite-scroll-component';

interface INotificationProps {
  initialStatus: number;
  setStatus: number;
}

interface INotificationList {
  id: number;
  message: string;
  read: number;
}

const Notification: React.FC<INotificationProps> = ({
  initialStatus,
  setStatus,
}) => {
  const { token } = useToken();

  const [loading, setLoading] = useState(false);
  const [page, setPage] = useState(0);
  const [lastPage, setLastPage] = useState(0);
  const [notificationsList, setNotificationsList] = useState<
    INotificationList[]
  >([]);

  const selectedStyle =
    'w-6 h-6 text-indigo-600 hover:text-slate-500 hover:cursor-pointer';
  const notSelectedStyle =
    'w-6 h-6 text-slate-500 hover:text-indigo-600 hover:cursor-pointer';

  const loadNotificationsList = async (pageNumber: number) => {
    setLoading(true);
    try {
      if (!loading) {
        const response = await get(
          `user/notifications?page=${pageNumber}&status=${setStatus}`,
          token
        );

        if (
          !response ||
          !response.data.notifications ||
          !response.data.notifications.data
        )
          throw new Error('Error while processing your request.');

        if (response.data.notifications.data.length === 0 && page === 1) {
          setPage(0);
          setLastPage(0);
        } else {
          const newNotifications = response.data.notifications.data;
          setNotificationsList((prevNotifications) => [
            ...prevNotifications,
            ...newNotifications,
          ]);
          setPage(Number(response.data.current_page) + 1);
          setLastPage(Number(response.data.last_page));
        }
      }
    } catch (e) {
      toast((e as Error).message);
    }
    setLoading(false);
  };

  const markRead = async (id: number) => {
    try {
      const response = await put(
        `user/notifications/toggle_read/${id}?status=${initialStatus}`,
        {},
        token
      );

      if (!response) throw new Error('Error while processing your request.');

      const updatedNotifications = notificationsList.filter(
        (notification) => notification.id !== id
      );
      setNotificationsList(updatedNotifications);
    } catch (e) {
      toast((e as Error).message);
    }
  };

  useEffect(() => {
    if (token) {
      loadNotificationsList(1);
    }
  }, [token]);

  return (
    <>
      <div id="tasks" className="my-5">
        <InfiniteScroll
          dataLength={notificationsList.length}
          next={() => loadNotificationsList(page)}
          hasMore={page <= lastPage}
          loader={
            <div className="flex justify-center items-center mt-4 ">
              <div className="spinner mr-2 "></div>
            </div>
          }
        >
          {notificationsList.map((notification) => (
            <div
              key={notification.id}
              id="task"
              className="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:from-slate-100 transition ease-linear duration-150"
            >
              <div className="inline-flex items-center space-x-2">
                <div onClick={() => markRead(notification.id)}>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    className={
                      notification.read ? selectedStyle : notSelectedStyle
                    }
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <div>{notification.message}</div>
              </div>
            </div>
          ))}
        </InfiniteScroll>
      </div>
      <p className="text-xs text-slate-500 text-center">
        {notificationsList.length ? notificationsList.length + 1 : 0}{' '}
        Notifications
      </p>
    </>
  );
};

export default Notification;
