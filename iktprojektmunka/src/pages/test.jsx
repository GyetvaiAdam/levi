import React, { useState, useEffect } from "react";
import { Typography, Card, CardBody, Radio, Button } from "@material-tailwind/react";
import axios from "axios";

export function Test() {
  const [questions, setQuestions] = useState([]); // Questions fetched from the backend
  const [responses, setResponses] = useState({}); // User responses

  // Fetch questions from the backend
  useEffect(() => {
    const fetchQuestions = async () => {
      try {
        const response = await axios.get("http://localhost/levi/php/test_question_load.php");
        if (response.data && Array.isArray(response.data)) {
          setQuestions(response.data);
        } else {
          console.error("Unexpected response format:", response.data);
        }
      } catch (error) {
        console.error("Error fetching questions:", error);
      }
    };

    fetchQuestions();
  }, []);

  // Handle radio button change
  const handleResponseChange = (questionIndex, value) => {
    setResponses((prevResponses) => ({
      ...prevResponses,
      [questionIndex]: value,
    }));
  };

  // Submit responses to the backend
  const handleSubmit = async () => {
    try {
      const response = await axios.post("http://localhost/levi/php/test_result.php", {
        responses,
      });
      if (response.data.success) {
        alert("Responses saved successfully!");
      } else {
        alert("Failed to save responses.");
      }
    } catch (error) {
      console.error("Error saving responses:", error);
      alert("An error occurred while saving your responses.");
    }
  };

  return (
    <div className="container mx-auto p-4">
      <Typography variant="h2" className="text-center my-4">
        Take the Test
      </Typography>
      {questions.length > 0 ? (
        questions.map((question, index) => (
          <Card key={index} className="my-4">
            <CardBody>
              <Typography variant="h5" className="mb-4">
                {question}
              </Typography>
              <div className="flex items-center justify-between">
                <Typography variant="paragraph" className="mr-4">
                  Disagree
                </Typography>
                <div className="flex justify-between w-full mx-4">
                  {Array.from({ length: 7 }, (_, i) => {
                    const size = 32 + Math.abs(3 - i) * 6;
                    return (
                      <Radio
                        key={i}
                        id={`question-${index + 1}-answer-${i + 1}`}
                        name={`question-${index}`}
                        value={i + 1}
                        style={{ width: size, height: size }}
                        onChange={() => handleResponseChange(index, i + 1)}
                      />
                    );
                  })}
                </div>
                <Typography variant="paragraph" className="ml-4">
                  Agree
                </Typography>
              </div>
            </CardBody>
          </Card>
        ))
      ) : (
        <Typography variant="paragraph" className="text-center my-4">
          Loading questions...
        </Typography>
      )}
      <div className="flex justify-center mt-8">
        <Button variant="filled" color="light-green" onClick={handleSubmit}>
          Send
        </Button>
      </div>
    </div>
  );
}

export default Test;
