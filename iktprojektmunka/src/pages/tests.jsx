import React, { useEffect, useState } from "react";
import { Avatar, Typography, Card, CardBody } from "@material-tailwind/react";
import axios from "axios";
import { Footer } from "@/widgets/layout";
import Initemail from './init.js';
import initcounter from "./initcount.js";

export function Profile() {
  const [userEmail, setUserEmail] = useState("");
  const [mbtiDetails, setMbtiDetails] = useState(null);
  const [testCount, setTestCount] = useState(0);

  useEffect(() => {
    const email = Initemail.email;
    setUserEmail(email);

    const count = initcounter || "0";
    setTestCount(count);

    if (count > 0 && email) {
      axios({
        method: "get",
        url: "http://localhost/levi/php/get_mbti.php",
        params: { email },
      })
        .then((response) => {
          setMbtiDetails(response.data);
          console.log("MBTI details:", response.data);
        })
        .catch((error) => {
          console.error("Error fetching MBTI details:", error.response);
        });
    }
  }, []);

  return (
    <>
      <section className="relative block h-[50vh]">
        <div className="bg-profile-background absolute top-0 h-full w-full bg-[url('/img/ong1.png')] bg-cover bg-center scale-105" />
        <div className="absolute top-0 h-full w-full bg-black/60 bg-cover bg-center" />
      </section>
      <section className="relative bg-white py-16">
        <div className="relative mb-6 -mt-40 flex w-full px-4 min-w-0 flex-col break-words bg-white">
          <div className="container mx-auto">
            <div className="flex flex-col lg:flex-row justify-between">
              <div className="relative flex gap-6 items-start">
                <div className="-mt-20 w-40">
                  <Avatar
                    src="/img/blank-profile-picture-973460_640.webp"
                    alt="Profile picture"
                    variant="circular"
                    className="h-full w-full"
                  />
                </div>
                <div className="flex flex-col mt-2">
                  <Typography variant="h4" color="blue-gray">
                    {userEmail || "Sign-in!"}
                  </Typography>
                </div>
              </div>

              <div className="mt-10 mb-10 flex lg:flex-col justify-between items-center lg:justify-end lg:mb-0 lg:px-4 flex-wrap lg:-mt-5">
                <div className="flex justify-start py-4 pt-8 lg:pt-4">
                  <div className="mr-4 p-3 text-center">
                    <Typography
                      variant="lead"
                      color="blue-gray"
                      className="font-bold uppercase"
                    >
                      {testCount}
                    </Typography>
                    <Typography
                      variant="small"
                      className="font-normal text-blue-gray-500"
                    >
                      Tests
                    </Typography>
                  </div>
                </div>
              </div>
            </div>

            <div className="mb-10 py-6">
              <div className="flex w-full flex-col items-start lg:w-1/2">
                {testCount === 0 ? (
                  <Typography className="mb-6 font-normal text-blue-gray-500">
                    Loading your results...
                  </Typography>
                ) : mbtiDetails ? (
                  <Card className="w-full shadow-lg">
                    <CardBody className="p-6">
                      <Typography
                        variant="h4"
                        color="blue-gray"
                        className="font-semibold mb-4"
                      >
                        Your MBTI Results
                      </Typography>
                      <Typography color="gray" className="mb-2">
                        <strong>Type:</strong> {mbtiDetails.type}
                      </Typography>
                      <Typography color="gray" className="mb-2">
                        <strong>Group:</strong> {mbtiDetails.group}
                      </Typography>
                      <Typography color="gray" className="mb-2">
                        <strong>Role:</strong> {mbtiDetails.role}
                      </Typography>
                      <Typography color="gray">
                        <strong>Description:</strong> {mbtiDetails.description}
                      </Typography>
                    </CardBody>
                  </Card>
                ) : (
                  <Typography className="mb-6 font-normal text-blue-gray-500">
                    Sign-in to see your results!
                  </Typography>
                )}
              </div>
            </div>
          </div>
        </div>
      </section>
      <div className="bg-white">
        <Footer />
      </div>
    </>
  );
}

export default Profile;
