import React from "react";
import { Typography, Card, CardBody, Radio, Button } from "@material-tailwind/react";

const questions = Array.from({ length: 50 }, (_, i) => `Question ${i + 1}`);

export function Test() {
  return (
    <div className="container mx-auto p-4">
      <Typography variant="h2" className="text-center my-4">
        Take the Test
      </Typography>
      {questions.map((question, index) => (
        <Card key={index} className="my-4">
          <CardBody>
            <Typography variant="h5" className="mb-4">
              {question}
            </Typography>
            <div className="flex items-center justify-between">
              <Typography variant="paragraph" className="mr-4">
                Agree
              </Typography>
              <div className="flex justify-between w-full mx-4">
                {Array.from({ length: 7 }, (_, i) => {
                  const size = 32 + Math.abs(3 - i) * 6;
                  return (
                    <Radio
                      key={i}
                      id={`question-${index + 1}-answer-${i + 1}`}
                      name={`question-${index + 1}`}
                      style={{ width: size, height: size }}
                    />
                  );
                })}
              </div>
              <Typography variant="paragraph" className="ml-4">
                Disagree
              </Typography>
            </div>
          </CardBody>
        </Card>
      ))}
      <div className="flex justify-center mt-8">
        <Button variant="filled" color="light-green">
          Send
        </Button>
      </div>
    </div>
  );
}

export default Test;